<?php 
session_start();

require '../db.php';

// Check if the user is logged in and is an admin
// if(!isset($_SESSION['user_id']) || $_SESSION['role'] = 'admin'){
//     header("Location:index.php");
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyBank - Manage Users</title>
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
                                    <a href="manage_users.php" class="nav-link active">
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

                        <!-- Admin Panel to manage user roles -->
                        <div class="container mt-5">
                            <h2>Manage Users</h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch users from database
                                    require '../db.php';
                                    $sql = "SELECT id, fullname, email, phone, role FROM users";
                                    $result = $conn->query($sql);

                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $i++ . "</td>";
                                        echo "<td>" . $row['fullname'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['role'] . "</td>";
                                        echo "<td>
                        <form action='update-role.php' method='POST'>
                            <input type='hidden' name='user_id' value='" . $row['id'] . "' />
                            <select name='role' class='form-control'>
                                <option value='user'" . ($row['role'] == 'user' ? ' selected' : '') . ">User</option>
                                <option value='admin'" . ($row['role'] == 'admin' ? ' selected' : '') . ">Admin</option>
                            </select>
                            <button type='submit' class='btn btn-primary mt-2'>Update Role</button>
                        </form>
                      </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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