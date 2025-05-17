<?php
session_start();
require '../db.php';

// Check if the user is logged in and is an admin
// if(!isset($_SESSION['user_id']) || $_SESSION['role'] = 'admin'){
//     header("Location:index.php");
//     exit();
// }

//For admin contact enquiry
if (isset($_POST['update_status'])) {

    $id = intval($_POST['enquiry_id']);
    $newStaus = $_POST['new_status'] === 'resolved' ? 'resolved' : 'pending';

    $stmt = $conn->prepare("UPDATE contact_messages SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStaus, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");

//Count total users
$sql = "SELECT COUNT(*) AS total_users FROM accounts";
$result1 = $conn->query($sql);

$totalUsers = 0;
if ($result1 && $result1->num_rows > 0) {
    $row = $result1->fetch_assoc();
    $totalUsers = $row['total_users'];
    $result1->free(); // free result
}

// Count total transactions
$trns = "SELECT COUNT(*) AS total_transactions FROM transactions";
$result2 = $conn->query($trns);

$totalTransactions = 0;
if ($result2 && $result2->num_rows > 0) {
    $row = $result2->fetch_assoc();
    $totalTransactions = $row['total_transactions'];
    $result2->free();
}

$stmt = $conn->prepare("SELECT
                accounts.fullname AS user,
                transactions.type,
                transactions.amount,
                transactions.created_at
                FROM transactions
                JOIN accounts
                ON transactions.user_id=accounts.id
                ORDER BY transactions.created_at DESC");
$stmt->execute();
$stmt->bind_result($fullname, $type, $amount, $created_at);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyBank -Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            /* background-color: #e9f0f7; */
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

                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="admin-dashboard.php" class="nav-link active">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="manage-users.php" class="nav-link ">
                                        <i class="bi bi-people me-2"></i> Manage Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="admin-transactions.php" class="nav-link">
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
                                        <i class="bi bi-bank me-2"></i> Withdraw Requests
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

                        <div class="container py-4">
                            <!-- <h1 class="mb-4">🏦 Admin Dashboard</h1> -->

                            <!-- Stats Cards -->
                            <div class="row mb-4">
                                <div class="col-md-4 mb-3">
                                    <div class="card text-white bg-primary h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Users</h5>
                                            <h3><?php echo $totalUsers ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card text-white bg-primary h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Transactions</h5>
                                            <h3> <?php echo $totalTransactions ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card text-white bg-primary h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Active Loans</h5>
                                            <!-- <h3>1,245</h3> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Transactions -->
                            <div class="card mb-4">
                                <div class="card-header fs-4 fw-bold">Recent Transactions</div>
                                <div class="card-body p-0">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php while ($stmt->fetch()) { ?>
                                                    <td><?php echo htmlspecialchars($fullname); ?></td>
                                                    <td><?php echo htmlspecialchars($type); ?></td>
                                                    <td>₹<?php echo number_format($amount); ?></td>
                                                    <td><?php echo htmlspecialchars($created_at); ?></td>
                                                </tr>
                                            <?php } ?>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <h3 class="mb-4 fs-4 fw-bold">Contact Enquiry</h3>
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td><?php echo htmlspecialchars($row['name']) ?></td>
                                                <td><?php echo htmlspecialchars($row['email']) ?></td>
                                                <td><?php echo htmlspecialchars($row['subject']) ?></td>
                                                <td><?php echo htmlspecialchars($row['message']) ?></td>
                                                <td><?php echo $row['submitted_at'] ?></td>
                                                <td>
                                                    <form method="POST" action="">
                                                        <input type="hidden" name="enquiry_id"
                                                            value="<?php echo $row['id'] ?>">
                                                        <input type="hidden" name="new_status"
                                                            value="<?php echo $row['status'] === 'pending' ? 'resolved' : 'pending' ?>">
                                                        <button type="submit" name="update_status"
                                                            class="btn btn-sm <?php echo ($row['status'] === 'pending' ? 'btn-danger' : 'btn-success'); ?>">
                                                            <?php echo $row['status'] === 'pending' ? '❌Pending' : '✅Resolved'; ?>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- KYC & Support -->

                            <!-- <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header">KYC Status</div>
                                        <div class="card-body">
                                            <ul class="list-unstyled">
                                                <li>✅ Approved: 12,000</li>
                                                <li>🕒 Pending: 2,500</li>
                                                <li>❌ Rejected: 730</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header">Support Tickets</div>
                                        <div class="card-body">
                                            <ul class="list-unstyled">
                                                <li>📩 Open: 125</li>
                                                <li>✅ Resolved: 980</li>
                                                <li>⚠️ Escalated: 10</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </main>

                </div>
            </div>

            <!-- Main Content -->

        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-primary text-white">
        &copy; <?php echo date('Y'); ?> EasyBank. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>