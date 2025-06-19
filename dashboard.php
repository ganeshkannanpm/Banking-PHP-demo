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

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname, email, phone, address, account_type, 
photo, signature, account_number, balance FROM accounts WHERE id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt->bind_result(
    $fullname,
    $email,
    $phone,
    $address,
    $account_type,
    $photo,
    $signature,
    $account_number,
    $balance
);

$stmt->fetch();
$stmt->close();

// Store in session
$_SESSION['user_name'] = $fullname;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
$_SESSION['address'] = $address;
$_SESSION['account_type'] = $account_type;
$_SESSION['photo'] = $photo;
$_SESSION['signature'] = $signature;
$_SESSION['account_number'] = $account_number;
$_SESSION['balance'] = $balance ?? 0.00;


// Fetch the last 5 transactions
$transactionsStmt = $conn->prepare("SELECT type, amount, created_at FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$transactionsStmt->bind_param("i", $user_id);
$transactionsStmt->execute();
$transactionsResult = $transactionsStmt->get_result();
$transactionsStmt->close();

// Get current month and year
$month = date('m');
$year = date('Y');

$stmt = $conn->prepare("SELECT COUNT(*) AS txn_count FROM transactions WHERE user_id = ? AND MONTH(created_at) = ? AND YEAR(created_at) = ?");
$stmt->bind_param("iii", $user_id, $month, $year);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$transactions_this_month = $row['txn_count'];

//Get Last Payment
$last_amount = '0.00';
$last_date = 'No payments yet';

$stmt = $conn->prepare("SELECT amount, created_at FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$last_payment = $result->fetch_assoc();

if ($last_payment) {
    $last_amount = '₹' . number_format($last_payment['amount'], 2);
    $last_date = date("jS M Y", strtotime($last_payment['created_at']));
}

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
                                    <a href="dashboard.php" class="nav-link active text-white ">
                                        <i class="bi bi-grid me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="create_account.php" class="nav-link text-white ">
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

                        <div class="container">
                            <!-- Card for Account Summary -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h4>Account Summary</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5>Account Balance</h5>
                                            <p><?php echo number_format($balance, 2); ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Transactions This Month</h5>
                                            <p><?php echo $transactions_this_month; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Last Payment</h5>
                                            <p><?php echo $last_amount; ?> - <?php echo $last_date; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <?php if (!empty($successMessage)): ?>
                                <div class="alert alert-success">
                                    <?php echo htmlspecialchars($successMessage) ?>
                                </div>
                            <?php endif; ?>

                        </div>

                        <!-- Profile Cards -->
                        <div class="row mt-5 mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img src="<?php echo htmlspecialchars($photo); ?>" width="150"
                                            class="rounded mb-2" alt="Photo">


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img src="<?php echo htmlspecialchars($signature); ?>" width="150"
                                            class="rounded mb-2" alt="Signature">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Details -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                                <p><strong>Account Type:</strong> <?php echo htmlspecialchars($account_type); ?></p>
                                <p><strong>Account Number:</strong> <?php echo htmlspecialchars($account_number); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                                <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
                                <!-- <p><strong>Balance:</strong> <spanclass="text-success">₹<?php echo number_format($balance, 2); ?></spanclass=></p> -->
                            </div>
                        </div>

                        <!-- Actions -->
                        <!-- <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="deposit.php" class="btn btn-primary">Deposit</a>
                            <a href="withdraw.php" class="btn btn-warning">Withdraw</a>
                            <a href="transactions.php" class="btn btn-info">Transactions</a>
                        </div> -->

                        <!-- Last 5 Transactions -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Last 5 Transactions</h5>
                            </div>
                            <div class="card-body p-0">
                                <?php if ($transactionsResult->num_rows > 0): ?>
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($transaction = $transactionsResult->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo ucfirst($transaction['type']); ?></td>
                                                    <td
                                                        class="<?php echo $transaction['type'] == 'withdraw' ? 'text-danger' : 'text-success'; ?>">
                                                        ₹<?php echo number_format($transaction['amount'], 2); ?>
                                                    </td>
                                                    <td><?php echo date('d M Y, h:i A', strtotime($transaction['created_at'])); ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p class="text-center py-3">No transactions found.</p>
                                <?php endif; ?>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>