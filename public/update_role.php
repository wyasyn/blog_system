<?php
session_start();
require '../includes/db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newRole = $_POST['role'];

    // Update the user's role
    $sql = "UPDATE users SET role = :role WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['role' => $newRole, 'user_id' => $userId]);

    // Redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
    exit();
}
?>
