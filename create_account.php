<?php
session_start();
require 'db.php';

if ($_SESSION['role'] === 'admin') {
    header("Location: admin-dashboard.php");
    exit();
}

$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = urldecode($_GET['success']);
}

// $user_id = $_SESSION['user_id'];
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname, photo FROM accounts WHERE id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt->bind_result(
    $fullname,
    $photo
);

$stmt->fetch();
$stmt->close();

// Store in session
$_SESSION['user_name'] = $fullname;
$_SESSION['photo'] = $photo;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
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
                    <h3 class="text-white">User Dashboard</h3>
                    <!-- <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                    </ul> -->
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
                                <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="User"
                                    class="rounded-circle" width="80" height="80">
                                <p class="mt-2">Hello,
                                    <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                                </p>
                            </div>

                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="dashboard.php" class="nav-link text-white ">
                                        <i class="bi bi-grid me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="create_account.php" class="nav-link active text-white ">
                                        <i class="bi bi-grid me-2"></i> Open Account
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="deposit.php" class="nav-link text-white">
                                        <i class="bi bi-cash-coin me-2"></i> Deposit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="withdraw.php" class="nav-link text-white">
                                        <i class="bi bi-cash me-2"></i> Withdraw
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="transactions.php" class="nav-link text-white">
                                        <i class="bi bi-clock-history me-2"></i> Transactions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="profile.php" class="nav-link text-white">
                                        <i class="bi bi-person-circle me-2"></i> Profile
                                    </a>
                                </li>
                                <li class="nav-item mt-3">
                                    <a href="logout.php" class="nav-link text-white">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </nav>


                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                        <div class="flex-grow-1 main-content">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white text-center">
                                    <h3 class="mb-0">🏦 Welcome to EasyBank Family</h3>
                                </div>
                                <div class="card-body">
                                    <form action="submit_account.php" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Full Name</label>
                                                <input type="text" class="form-control" name="fullname" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email Address</label>
                                                <input type="email" class="form-control" name="email" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Phone Number</label>
                                                <input type="tel" class="form-control" name="phone" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" name="dob" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Gender</label>
                                                <select class="form-select" name="gender" required>
                                                    <option value="">Select</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">PAN Number</label>
                                                <input type="text" class="form-control" name="pan_number" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Profile Photo</label>
                                                <input type="file" class="form-control" name="photo" accept="image/*"
                                                    required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">ID Proof</label>
                                                <input type="file" class="form-control" name="id_proof_front"
                                                    accept="image/*" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Residential Address</label>
                                                <textarea class="form-control" name="address" rows="3"
                                                    required></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Account Type</label>
                                                <select class="form-select" name="account_type" required>
                                                    <option value="">Select Account Type</option>
                                                    <option value="savings">Savings Account</option>
                                                    <option value="current">Current Account</option>
                                                    <option value="joint">Joint Account</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Signature</label>
                                                <input type="file" class="form-control" name="signature"
                                                    accept="image/*" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Open Account</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </main>
                    <script>
                        function togglePassword() {
                            const passInput = document.getElementById("password");
                            passInput.type = passInput.type === "password" ? "text" : "password";
                        }
                    </script>
                </div>
            </div>

            <!-- Main Content -->

        </div>
    </div>


    <!-- Footer -->
    <footer class="text-center py-3 bg-primary text-white">
        &copy; <?php echo date('Y'); ?> EasyBank. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>