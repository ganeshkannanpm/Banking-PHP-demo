<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT fullname, dob, gender, email, phone, address, account_type, 
    pan_number, photo, id_proof, signature, account_number, balance FROM accounts WHERE id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt->bind_result(
  $fullname,
  $dob,
  $gender,
  $email,
  $phone,
  $address,
  $account_type,
  $pan_number,
  $photo,
  $id_proof,
  $signature,
  $account_number,
  $balance
);

$stmt->fetch();
$stmt->close();

// Store in session
$_SESSION['fullname'] = $fullname;
$_SESSION['dob'] = $dob;
$_SESSION['gender'] = $gender;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
$_SESSION['address'] = $address;
$_SESSION['account_type'] = $account_type;
$_SESSION['pan_number'] = $pan_number;
$_SESSION['photo'] = $photo;
$_SESSION['id_proof'] = $id_proof;
$_SESSION['signature'] = $signature;
$_SESSION['account_number'] = $account_number;
$_SESSION['balance'] = $balance;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .button:hover {
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

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <h3 class="text-white">EasyBank</h3>
      <div class="d-flex">
        <div class=" nav-menu me-5 gap-2">
          <a href="edit-profile.php" class="btn button btn-primary mb-3">Edit Profile</a>
        </div>
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
              <a href="transactions.php" class="nav-link text-white">
                <i class="bi bi-clock-history me-2"></i> Transactions
              </a>
            </li>
            <li class="nav-item">
              <a href="profile.php" class="nav-link active text-white">
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
        <div class="container">
          <div class="">
            <h2 class="mb-4 text-center">Account Details</h2>

            <div class="row">
              <div class="col-md-6 mb-3"><img src="<?php echo htmlspecialchars($photo); ?>" width="150" height="150"
                  alt=""></div>
              <div class="col-md-6 mb-3"><img src="<?php echo htmlspecialchars($id_proof); ?>" width="150" height="150"
                  alt=""></div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 fs-5"><strong>Name:</strong> <?php echo htmlspecialchars($fullname); ?></div>
              <div class="col-md-6 fs-5"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 fs-5"><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></div>
              <div class="col-md-6 fs-5"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 fs-5"><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></div>
              <div class="col-md-6 fs-5"><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 fs-5"><strong>Account Type:</strong> <?php echo htmlspecialchars($account_type); ?>
              </div>
              <div class="col-md-6 fs-5"><strong>Pan Number:</strong> <?php echo htmlspecialchars($pan_number); ?></div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 fs-5"><strong>Account Number:</strong>
                <?php echo htmlspecialchars($account_number); ?>
              </div>
              <div class="col-md-4"><img src="<?php echo htmlspecialchars($signature); ?>" width="150" height="150"
                  alt="">
              </div>
            </div>

          </div>

        </div>
      </main>


    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center py-3 bg-primary text-white">
    &copy; <?php echo date('Y'); ?> EasyBank. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>