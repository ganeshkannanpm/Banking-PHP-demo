<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn-contact'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo
            "<script>
                alert('Message submitted successfully!');
                window.location.href = 'index.php';
        </script>";

    } else {
        echo "Message submission failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}