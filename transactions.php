<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT fullname, account_type, account_number, balance FROM accounts WHERE id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt->bind_result($fullname, $account_type, $account_number, $balance);

$stmt->fetch();
$stmt->close();

// Store in session
$_SESSION['fullname'] = $fullname;
$_SESSION['account_type'] = $account_type;
$_SESSION['account_number'] = $account_number;
$_SESSION['balance'] = $balance;

$stmt = $conn->prepare("SELECT type, amount, created_at FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Transaction History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <!-- for pdf -->


  <style>
    /* print only a specific <div> and hide everything else on the page. */
    @media print {
      body * {
        visibility: hidden;
      }

      #transactionContent,
      #transactionContent * {
        visibility: visible;
      }

      #transactionContent {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
      }
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

    button:hover {
      background-color: rgb(255, 255, 255) !important;
      color: black !important;
      border-radius: 4px;
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
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <h3 class="text-white">EasyBank</h3>
      <div class="d-flex">

        <div class=" nav-menu me-5 gap-2">
          <!-- <button a href="dashboard.php" class="btn btn-primary mb-3">← Back to Dashboard</a></button> -->
          <button class="btn btn-primary mb-3" onclick="downloadPDF()">Download</button>
          <button class="btn btn-primary mb-3" onclick="window.print()">Print</button>
        </div>

        <!-- <span class="navbar-text text-white ms-5 me-3">Welcome,
          <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <div class="dropdown text-end">
          <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="mdo" width="32" height="32"
            class="rounded-circle"> -->
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
              <a href="withdraw.php" class="nav-link  text-white">
                <i class="bi bi-cash me-2"></i> Withdraw
              </a>
            </li>
            <li class="nav-item">
              <a href="transactions.php" class="nav-link active text-white">
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
        <div id="transactionContent">
          <div class="container my-5">
            <h3 class="mb-4 bg-light text-dark">Transaction History</h3>
            <hr>

            <div>
              <div class="row mb-3">
                <div class="col-md-6 fs-5"><strong>Name:</strong> <?php echo htmlspecialchars($fullname); ?></div>
                <div class="col-md-6 fs-5"><strong>Account Type:</strong> <?php echo htmlspecialchars($account_type); ?>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6 fs-5"><strong>Account Number:</strong>
                  <?php echo htmlspecialchars($account_number); ?>
                </div>
                <div class="col-md-6 fs-5"><strong>Current Balance:</strong> ₹<?php echo number_format($balance, 2) ?>
                </div>
              </div>
            </div>

            <table class="table table-bordered table-striped">
              <thead class="table-secondary">
                <tr>
                  <th>No</th>
                  <th>Type</th>
                  <th>Amount(₹)</th>
                  <th>Date</th>
                  <th>Available Balance(₹)</th> <!-- New column -->
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                $balance = 0;

                // To correctly show balance, fetch transactions in chronological order (oldest first)
                $transactions = [];
                while ($row = $result->fetch_assoc()) {
                  $transactions[] = $row;
                }
                // Reverse the array to start from the oldest transaction
                $transactions = array_reverse($transactions);

                foreach ($transactions as $row):
                  $type = strtolower($row['type']);
                  $amount = (float) $row['amount'];

                  if ($type === 'deposit') {
                    $balance += $amount;
                  } elseif ($type === 'withdraw') {
                    $balance -= $amount;
                  }
                  ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo ucfirst($type); ?></td>
                    <td><?php echo number_format($amount, 2); ?></td>
                    <td><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></td>
                    <td><?php echo number_format($balance, 2); ?></td> <!-- Show running balance -->
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

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

  <script>
    function downloadPDF() {
      const element = document.getElementById('transactionContent');
      const opt = {
        margin: 0.5,
        filename: 'transaction-history.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
      };
      html2pdf().set(opt).from(element).save();
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>