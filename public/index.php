<?php
require '../includes/db.php';

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
    <h1>All Blogs</h1>
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
