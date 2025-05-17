<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-deposit'])) {
    $amount = (int) $_POST['amount'];
    if ($amount > 0) {
        // Get current balance
        $stmt = $conn->prepare("SELECT balance FROM accounts WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($current_balance);
        $stmt->fetch();
        $stmt->close();

        // Update balance
        $new_balance = $current_balance + $amount;
        $stmt = $conn->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
        $stmt->bind_param("di", $new_balance, $user_id);
        $stmt->execute();
        $stmt->close();

        // Log transaction
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, amount) VALUES (?, 'deposit', ?)");
        $stmt->bind_param("id", $user_id, $amount);
        $stmt->execute();
        $stmt->close();

        // Success message
        $successMessage = "₹" . number_format($amount) . " deposited successfully!";
        header("Location: dashboard.php?success=" . urlencode($successMessage));
        exit();
    }
}
?>
