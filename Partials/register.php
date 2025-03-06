<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim(isset($_POST['password']) ? $_POST['password'] : '');
    $age = trim(isset($_POST['age']) ? $_POST['age'] : '');
    $bio = trim(isset($_POST['bio']) ? $_POST['bio'] : '');
    $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        

    if (isset($_FILES["profilePic"]["name"]) && isset($_FILES["profilePic"]["error"])){
        $profilePic = $_FILES["profilePic"];
    }else {
        $profilePic = null;
    }

    $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);
    $profileBio = filter_input(INPUT_POST, "bio", FILTER_SANITIZE_SPECIAL_CHARS);
    $error = "";
    

    if (empty($username) || empty($password) || empty($profilePic['name']) || empty($profileBio) || empty($age)) {
        echo "<p class= 'registerError'>pleas fill evrything in the registration </p>";
    
    }else {
        $aploud = "uploads/";
        $file_name = $aploud . basename ($profilePic["name"]);;
        $aploud_check = 1;

        if (getimagesize($profilePic["tmp_name"]) === false){
            echo "File is not an image";
            $apload_check = 0;
        }

        if ($profilePic["size"] > 5000000){
            echo "File is too big";
            $aploud_check = 0;
        }

        if ($apload_check = 1){

            if (move_uploaded_file($profilePic["tmp_name"], $file_name)){

                echo    "";
            }
        }


        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (user, password, age, bio, profile_pic) VALUES ('$username', '$hash', '$age', '$profileBio', '$file_name')";

       try {
        mysqli_query($conn, $sql);
        echo "Registration succesfull";

        header("location: index.php");
       }catch (mysqli_sql_exception){
        echo "<p class = 'error'>This Username is allready taken</p>";
       }
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