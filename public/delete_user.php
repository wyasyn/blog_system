<?php
session_start();
require '../includes/db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the 'id' parameter is set
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);

    // Redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
    exit();
}
?>
