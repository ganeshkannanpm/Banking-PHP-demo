<?php

session_start();
require 'db.php';

if (!$_SESSION['user_id']) {
  header("Location: dashboard.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT balance FROM accounts WHERE id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt->bind_result($balance);

$stmt->fetch();
$stmt->close();

// Store in session
$_SESSION['balance'] = $balance;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Withdraw Money</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
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
  <nav class="navbar navbar-expand-lg navbar-primary bg-primary">
    <div class="container">
      <h3 class="text-white">EasyBank</h3>
      <div class="d-flex">
        <!-- <span class="navbar-text text-white ms-5 me-3">Welcome,
          <?php echo htmlspecialchars($_SESSION['user_name']); ?></span> -->
        <div class="dropdown text-end">
          <span class="navbar-text text-white ms-5 fs-5 me-3">Current Balance: ₹
            <?php echo number_format($balance, 2); ?></span>
          <!-- <a href="#" class="d-block link-body-emphasis text-decoration-none"
            aria-expanded="false">
          </a> -->
        </div>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
        <div class="position-sticky p-3">
          <div class="text-center mb-4">
            <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="User" class="rounded-circle" width="80"
              height="80">
            <p class="mt-2">Hello, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
          </div>

          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="dashboard.php" class="nav-link  text-white ">
                <i class="bi bi-grid me-2"></i> Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a href="create_account.php" class="nav-link text-white ">
                <i class="bi bi-grid me-2"></i> Open Account
              </a>
            </li>
            <li class="nav-item">
              <a href="deposit.php" class="nav-link  text-white ">
                <i class="bi bi-cash-coin me-2"></i> Deposit
              </a>
            </li>
            <li class="nav-item">
              <a href="withdraw.php" class="nav-link active text-white">
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

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
        <div class="container my-5">
          <div class="row justify-content-center">
            <div class="col-md-5">
              <h3 class="mb-4 text-center">Withdraw Money</h3>
              <form action="withdraw-process.php" method="POST">
                <div class="mb-3">
                  <label for="amount" class="form-label">Enter Amount (₹)</label>
                  <input type="number" class="form-control" name="amount" id="amount" min="1" required>
                </div>
                <button type="submit" name="btn-withdraw" class="btn btn-primary w-100">Withdraw</button>
                <!-- <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a> -->
              </form>
            </div>
          </div>
        </div>
      </main>


    </div>
  </div>



  <!-- Footer -->
  <div style="position: fixed; bottom: 0; left: 0; width: 100%; text-align: center;">
    <footer class="text-center py-3 bg-primary mt-4 text-white">
      &copy; <?php echo date('Y'); ?> EasyBank. All rights reserved.
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>