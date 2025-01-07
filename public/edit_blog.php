<?php
session_start();
require '../includes/db.php';

// Check if the user is logged in and is an author
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'author') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $blogId = $_GET['id'];

    // Fetch the blog to edit
    $sql = "SELECT * FROM blogs WHERE id = :id AND author_id = :author_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $blogId, 'author_id' => $_SESSION['user_id']]);
    $blog = $stmt->fetch();

    if (!$blog) {
        header('Location: author_dashboard.php'); // If the blog doesn't exist or the user isn't the author, redirect
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $image = $_FILES['image']['name'];
    
    // Handle file upload
    if ($image) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        $imageUrl = "uploads/" . $image;
    } else {
        $imageUrl = $blog['image_url']; // Keep the old image if no new one is uploaded
    }

    // Update the blog in the database
    $sql = "UPDATE blogs SET title = :title, content = :content, category = :category, tags = :tags, image_url = :image_url WHERE id = :id AND author_id = :author_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $title,
        'content' => $content,
        'category' => $category,
        'tags' => $tags,
        'image_url' => $imageUrl,
        'id' => $blogId,
        'author_id' => $_SESSION['user_id']
    ]);

    // Redirect to the author dashboard
    header('Location: author_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
</head>
<body>
    <h1>Edit Blog: <?= htmlspecialchars($blog['title']) ?></h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required><br>
        <label for="content">Content:</label>
        <textarea name="content" rows="5" required><?= htmlspecialchars($blog['content']) ?></textarea><br>
        <label for="category">Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($blog['category']) ?>" required><br>
        <label for="tags">Tags:</label>
        <input type="text" name="tags" value="<?= htmlspecialchars($blog['tags']) ?>"><br>
        <label for="image">Image:</label>
        <input type="file" name="image"><br>
        <button type="submit">Update Blog</button>
    </form>

    <p><a href="author_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
