<?php
session_start();
require '../includes/db.php';

if ($_SESSION['role'] !== 'author' && $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authorId = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];

    $imageUrl = null;
    if (!empty($_FILES['image']['name'])) {
        $imageUrl = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imageUrl);
    }

    $sql = "INSERT INTO blogs (author_id, title, content, image_url, category, tags) VALUES (:author_id, :title, :content, :image_url, :category, :tags)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'author_id' => $authorId,
        'title' => $title,
        'content' => $content,
        'image_url' => $imageUrl,
        'category' => $category,
        'tags' => $tags
    ]);

    $success = "Blog created successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Blog</title>
</head>
<body>
    <form method="POST" action="" enctype="multipart/form-data">
        <h1>Create Blog</h1>
        <?php if (isset($success)) echo "<p>$success</p>"; ?>
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="content" placeholder="Content" required></textarea>
        <input type="text" name="category" placeholder="Category">
        <input type="text" name="tags" placeholder="Tags">
        <input type="file" name="image">
        <button type="submit">Create Blog</button>
    </form>
</body>
</html>
