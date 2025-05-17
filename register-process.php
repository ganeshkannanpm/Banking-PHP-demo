<?php 

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-register'])) {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password != $confirm_password) {
        die("Passwords do not match");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("Email already registered. Please use a different email.");
    }

    // Set the role to 'user' automatically (no input needed from user)
    $role = 'user';

    // Insert user data into the database with default 'user' role
    $Stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
    $Stmt->bind_param("sssss", $fullname, $email, $phone, $hashed_password, $role);

    // Check if the insert is successful
    if ($Stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please login.');
                window.location.href = 'index.php';
        </script>";
        exit();
    } else {
        echo "Error: " . $Stmt->error;
    }

    // Close connections
    $Stmt->close();
    $check->close();
    $conn->close();
}
?>
