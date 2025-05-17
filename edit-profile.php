<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Handle image uploads
    function uploadImage($fieldName, $oldFile)
    {
        if ($_FILES[$fieldName]['error'] == 0) {
            $ext = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
            $filename = 'assets/uploads/' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filename);
            return $filename;
        }
        return $oldFile;
    }

    // Get current file paths from DB
    $stmt = $conn->prepare("SELECT photo, signature, id_proof FROM accounts WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($oldPhoto, $oldSignature, $oldIdProof);
    $stmt->fetch();
    $stmt->close();

    $photo = uploadImage('photo', $oldPhoto);
    $signature = uploadImage('signature', $oldSignature);
    $id_proof = uploadImage('id_proof', $oldIdProof);

    $stmt = $conn->prepare("UPDATE accounts SET fullname=?, dob=?, gender=?, email=?, phone=?, address=?, photo=?, signature=?, id_proof=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $fullname, $dob, $gender, $email, $phone, $address, $photo, $signature, $id_proof, $user_id);

    if ($stmt->execute()) {
        // Update session
        $_SESSION['fullname'] = $fullname;
        $_SESSION['dob'] = $dob;
        $_SESSION['gender'] = $gender;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['address'] = $address;
        $_SESSION['photo'] = $photo;
        $_SESSION['signature'] = $signature;
        $_SESSION['id_proof'] = $id_proof;

        header("Location: profile.php");
        exit();
    } else {
        echo "Failed to update profile.";
    }

    $stmt->close();
}

// Fetch current data
$stmt = $conn->prepare("SELECT fullname, dob, gender, email, phone, address, photo, signature, id_proof FROM accounts WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $dob, $gender, $email, $phone, $address, $photo, $signature, $id_proof);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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
                <h4 class="text-white">Edit Profile</h4>
                    <!-- <a href="#" class="d-block link-body-emphasis text-decoration-none"
            aria-expanded="false">
          </a> -->
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid mb-5">
        <div class="row">

            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky p-3">
                    <div class="text-center mb-4">
                        <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="User" class="rounded-circle"
                            width="80" height="80">
                        <p class="mt-2">Hello, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                        </p>
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
                <div class="container mb-5">
                    <!-- <h2>Edit Profile</h2> -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control"
                                value="<?php echo htmlspecialchars($fullname); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
                                value="<?php echo htmlspecialchars($dob); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" <?php if ($gender == "Male")
                                    echo "selected"; ?>>Male</option>
                                <option value="Female" <?php if ($gender == "Female")
                                    echo "selected"; ?>>Female</option>
                                <option value="Other" <?php if ($gender == "Other")
                                    echo "selected"; ?>>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="<?php echo htmlspecialchars($phone); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control"
                                required><?php echo htmlspecialchars($address); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Photo (Profile Image)</label><br>
                            <img src="<?php echo htmlspecialchars($photo); ?>" width="100" class="mb-2"><br>
                            <input type="file" name="photo" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label>Signature</label><br>
                            <img src="<?php echo htmlspecialchars($signature); ?>" width="100" class="mb-2"><br>
                            <input type="file" name="signature" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label>ID Proof</label><br>
                            <img src="<?php echo htmlspecialchars($id_proof); ?>" width="100" class="mb-2"><br>
                            <input type="file" name="id_proof" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="profile.php" class="btn btn-primary">Cancel</a>
                    </form>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>