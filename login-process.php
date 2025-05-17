<?php
session_start();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Only select what's needed for login
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Store minimal session data
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: admin/admin-dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.'); window.location.href='index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
