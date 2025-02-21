<?php
session_start();
require '../includes/db.php';

// Check if the user is logged in and is an author
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'author') {
    header('Location: login.php');
    exit();
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
    }
    
    // Insert new blog into the database
    $sql = "INSERT INTO blogs (author_id, title, content, category, tags, image_url, created_at) 
            VALUES (:author_id, :title, :content, :category, :tags, :image_url, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'author_id' => $_SESSION['user_id'],
        'title' => $title,
        'content' => $content,
        'category' => $category,
        'tags' => $tags,
        'image_url' => $image ? "uploads/" . $image : null
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
    <title>Create Blog</title>
</head>
<body>
    <h1>Create a New Blog</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>
        <label for="content">Content:</label>
        <textarea name="content" rows="5" required></textarea><br>
        <label for="category">Category:</label>
        <input type="text" name="category" required><br>
        <label for="tags">Tags:</label>
        <input type="text" name="tags"><br>
        <label for="image">Image:</label>
        <input type="file" name="image"><br>
        <button type="submit">Create Blog</button>
    </form>

    <p><a href="author_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
