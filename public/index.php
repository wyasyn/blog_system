<?php
require '../includes/db.php';

// Check if the user is logged in
session_start();
$isLoggedIn = isset($_SESSION['user_id']);  // Check if there's a logged-in user
$userRole = $isLoggedIn ? $_SESSION['role'] : null;  // Get user role (e.g., 'admin', 'author', or 'user')

// Fetch blogs from the database
$sql = "SELECT b.*, u.username AS author FROM blogs b JOIN users u ON b.author_id = u.id ORDER BY b.created_at DESC";
$stmt = $pdo->query($sql);
$blogs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog System</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Navigation Links -->
    <div class="nav-links">
        <?php if ($isLoggedIn): ?>
            <!-- Links for logged-in users based on their role -->
            <?php if ($userRole === 'admin'): ?>
                <a href="../admin_dashboard.php">Admin Dashboard</a> <!-- Admin dashboard link -->
            <?php elseif ($userRole === 'author'): ?>
                <a href="../author_dashboard.php">Author Dashboard</a> <!-- Author dashboard link -->
            <?php endif; ?>
            <a href="../logout.php">Logout</a> <!-- Logout link -->
        <?php else: ?>
            <a href="../login.php">Login</a> <!-- Login link for users who are not logged in -->
            <a href="../register.php">Register</a> <!-- Register link -->
        <?php endif; ?>
    </div>

    <h1>All Blogs</h1>

    <!-- Loop through blogs and display them -->
    <?php foreach ($blogs as $blog): ?>
        <h2><?= htmlspecialchars($blog['title']) ?></h2>
        <p>By <?= htmlspecialchars($blog['author']) ?> on <?= $blog['created_at'] ?></p>
        <p><?= htmlspecialchars($blog['content']) ?></p>
        <?php if ($blog['image_url']): ?>
            <img src="../<?= htmlspecialchars($blog['image_url']) ?>" alt="Blog Image" style="width: 300px;">
        <?php endif; ?>
        <p>Category: <?= htmlspecialchars($blog['category']) ?></p>
        <p>Tags: <?= htmlspecialchars($blog['tags']) ?></p>
        <hr>
    <?php endforeach; ?>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
