<?php
session_start();
require '../includes/db.php';

// Check if the user is logged in and is an author
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'author') {
    header('Location: login.php'); // Redirect to login if not an author
    exit();
}

// Fetch the author's blog posts
$sql = "SELECT * FROM blogs WHERE author_id = :author_id ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['author_id' => $_SESSION['user_id']]);
$blogs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Dashboard</title>
</head>
<body>
    <h1>Author Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

    <h2>Your Blog Posts</h2>
    <a href="create_blog.php">Create a New Blog</a>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($blogs as $blog): ?>
        <tr>
            <td><?= htmlspecialchars($blog['title']) ?></td>
            <td><?= htmlspecialchars($blog['category']) ?></td>
            <td><?= htmlspecialchars($blog['created_at']) ?></td>
            <td>
                <!-- Edit Blog -->
                <a href="edit_blog.php?id=<?= $blog['id'] ?>">Edit</a> | 
                <!-- Delete Blog -->
                <a href="delete_blog.php?id=<?= $blog['id'] ?>" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Your Details</h2>
    <a href="edit_profile.php">Edit Your Details</a>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
