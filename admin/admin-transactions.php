<?php
session_start();

require '../db.php';

// Pagination setup
$limit = 5; // transactions per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Filter setup
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';

// Base SQL
$sql = "SELECT 
    transactions.id,
    accounts.fullname AS customer_name,
    transactions.type,
    transactions.amount,
    transactions.created_at
FROM 
    transactions
JOIN 
    accounts ON transactions.user_id = accounts.id";

// Apply filter
$where = "";
if ($type_filter === 'deposit' || $type_filter === 'withdraw') {
    $where = " WHERE transactions.type = '" . mysqli_real_escape_string($conn, $type_filter) . "'";
    $sql .= $where;
}

// Count total records (with filter applied)
$count_sql = "SELECT COUNT(*) as total
              FROM transactions
              JOIN accounts ON transactions.user_id = accounts.id" . $where;

$count_result = mysqli_query($conn, $count_sql);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Add limit for pagination
$sql .= " ORDER BY transactions.created_at DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyBank - Admin Transactions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .pagination,
        .filters {
            text-align: center;
            margin: 20px;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            padding: 6px 12px;
            background: #f4f4f4;
            border: 1px solid #ccc;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
        }

        .sidebar {
            background-color: #0d6efd;
            color: white;
            min-height: 100vh;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: rgb(255, 255, 255);
            color: black !important;
            border-radius: 4px;
        }

        .nav-link.active {
            background-color: white;
            color: black !important;
        }

        @media (min-width: 768px) {
            #sidebarMenu {
                display: block !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar bg-primary">
        <div class="container">
            <h3 class="text-white">EasyBank</h3>

            <div class="d-flex">

                <div class=" text-end">
                    <h4 class="text-white"> 🏦Admin Dashboard</h4>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Navbar toggle for small screens -->
            <nav class="navbar navbar-dark bg-primary d-md-none">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#sidebarMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand">Banking Dashboard</span>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row">

                    <!-- Sidebar -->
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                        <div class="position-sticky p-3">
                            <div class="text-center mb-4">
                                <!-- <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="User"
                                    class="rounded-circle" width="80" height="80">
                                <p class="mt-2">Hello,
                                    <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                                </p> -->
                            </div>

                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="admin-dashboard.php" class="nav-link">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="manage-users.php" class="nav-link">
                                        <i class="bi bi-people me-2"></i> Manage Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="admin-transactions.php" class="nav-link active">
                                        <i class="bi bi-list-ul me-2"></i> Transactions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="deposit_requests.php" class="nav-link">
                                        <i class="bi bi-piggy-bank me-2"></i> Deposit Requests
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="withdraw_requests.php" class="nav-link">
                                        <i class="bi bi-bank me-2"></i>Withdraw Requests
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="loans.php" class="nav-link">
                                        <i class="bi bi-currency-dollar me-2"></i> Loan Management
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="reports.php" class="nav-link">
                                        <i class="bi bi-clipboard-data me-2"></i> Reports
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="settings.php" class="nav-link">
                                        <i class="bi bi-gear me-2"></i> Settings
                                    </a>
                                </li>
                                <li class="nav-item mt-3">
                                    <a href="../logout.php" class="nav-link text-white">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </nav>


                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                        <h2 style="text-align:center;">All Transactions</h2>

                        <!-- Filter -->
                        <div class="filters">
                            <form method="GET">
                                <label>Filter by Type:</label>
                                <select name="type">
                                    <option value="">All</option>
                                    <option value="deposit" <?php echo ($type_filter === 'deposit') ? 'selected' : ''; ?>>
                                        Deposit</option>
                                    <option value="withdraw" <?php echo ($type_filter === 'withdraw') ? 'selected' : ''; ?>>Withdraw</option>
                                </select>
                                <button class="btn btn-primary" type="submit">Apply</button>
                            </form>
                        </div>

                        <!-- Transaction Table -->
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>


                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['id']) ?></td>
                                            <td><?php echo htmlspecialchars($row['customer_name']) ?></td>
                                            <td><?php echo htmlspecialchars($row['type']) ?></td>
                                            <td><?php echo htmlspecialchars($row['amount']) ?></td>
                                            <td><?php echo htmlspecialchars($row['created_at']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No transactions found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="pagination">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?type=<?php echo urlencode($type_filter); ?>&page=<?php echo $i; ?>"
                                    class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>

                            <?php endfor; ?>
                        </div>

                    </main>

                </div>
            </div>

            <!-- Footer -->
             
            <footer class="text-center py-3 bg-primary text-white">
                &copy; <?php echo date('Y'); ?> EasyBank. All rights reserved.
            </footer>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>

</body>

</html>
<?php mysqli_close($conn); ?>