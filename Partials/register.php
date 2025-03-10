<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "header.php";
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);
    $profileBio = filter_input(INPUT_POST, "bio", FILTER_SANITIZE_SPECIAL_CHARS);
    $error = "";

    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $profilePicPath = "default.jpg";
    if (!empty($_FILES["profilePic"]["name"]) && $_FILES["profilePic"]["error"] === 0) {
        $file_name = basename($_FILES["profilePic"]["name"]);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
            $profilePicPath = $target_file;
        }
    }

    if (empty($username) || empty($password) || empty($profileBio) || empty($age)) {
        echo "<p class='registerError'>Please fill in all the required fields.</p>";
    } else {
        $_SESSION['user'] = $username;
        $_SESSION['profile_pic'] = $profilePicPath;
        header("Location: post.php");
        exit();
    }
}

mysqli_close($conn);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="../Main.css">
</head>
<body>
<div class="container">
    <h2>Create an account</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="register.php" method="POST" enctype="multipart/form-data">

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name = "profilePic" id="profile_picture" required>

        <label for="username">Username:</label>
        <input type="text" name = "username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name ="password"id="password" required>

        <label for="age">Age:</label>
        <input type="number" name = "age" id="age" required>

        <label for="bio">Bio:</label>
        <input type="text" name = "bio" id="bio" required>

        <input type="submit" name = "submit" value = "register" >
    </form>
    <p>Already have an account? <a href="index.php">Login</a></p>
</div>
</body>
</html>
