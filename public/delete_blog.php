<?php
session_start();
require '../includes/db.php';

// Check if the user is logged in and is an author
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'author') {
    header('Location: login.php');
    exit();
}

// Check if the 'id' parameter is set
if (isset($_GET['id'])) {
    $blogId = $_GET['id'];

    // Delete the blog from the database
    $sql = "DELETE FROM blogs WHERE id = :id AND author_id = :author_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $blogId, 'author_id' => $_SESSION['user_id']]);

    // Redirect back to the author dashboard
    header('Location: author_dashboard.php');
    exit();
}
?>
