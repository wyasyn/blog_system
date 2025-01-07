<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Check if the user exists and if the password matches
    if ($user && password_verify($password, $user['password'])) {
        // Check if the user's account is approved
        if ($user['status'] === 'approved') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; // Store user role in session

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php"); // Admin dashboard
                exit;
            } elseif ($user['role'] === 'author') {
                header("Location: author_dashboard.php"); // Author dashboard
                exit;
            } else {
                header("Location: index.php"); // Regular user or guest
                exit;
            }
        } else {
            $error = "Account not approved yet.";
        }
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        <h1>Login</h1>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
