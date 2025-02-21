<?php
include "header.php";
session_start();

if (isset($_SESSION['user']) || isset($_COOKIE['remembered_user'])) {
    $_SESSION['user'] = isset($_COOKIE['remembered_user']) ? $_COOKIE['remembered_user'] : $_SESSION['user'];
    header("Location: ../Partials/post.php");
    exit();
}

$valid_username = "testuser";
$valid_password = "password123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['user'] = $username;

        if (isset($_POST['rememberMe'])) {
            setcookie("remembered_user", $username, time() + (86400 * 30), "/");
        }

        header("Location: ../Partials/post.php");
        exit();
    } else {
        $error = "Username or Password is incorrect!";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Chirpify</title>
    <link rel="stylesheet" href="Main.css">
    <script defer src="Main.js"></script>
</head>
<body>
<div class="container">
    <h2>Log in to Chirpify</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form action="post.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <div class="rememberMe">
            <input type="checkbox" name="rememberMe" id="rememberMe">
            <label for="rememberMe">Remember me</label>
        </div>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php"> Sign up here</a></p>
</div>
</body>
</html>