<?php
session_start();
require 'db.php';

if ($_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

$sql = "SELECT * FROM users WHERE status = 'pending'";
$stmt = $pdo->query($sql);
$pendingUsers = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $sql = "UPDATE users SET status = 'approved' WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $userId]);
    echo "User approved.";
}
?>
