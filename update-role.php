<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    // Validate role
    if ($role != 'user' && $role != 'admin') {
        die("Invalid role.");
    }

    // Update the role in the database
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $role, $user_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Role updated successfully.');
                window.location.href = 'admin-dashboard.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
