<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "header.php";
include("database.php");
 

if (!isset($_COOKIE["cookie_consent"])) {

?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Chirpify - Cookie Consent</title>
        <link rel="stylesheet" href="Main.css">
        <script defer src="Main.js"></script>
    </head>
    <body>

    <div class="cookieOverlay" id="cookieOverlay"></div>
    <div class="cookieBox" id="cookieBox">
        <p>This website uses cookies to enhance your experience. For more information, please read our policy.</p>
        <button onclick="toggleTerms()">Show Terms & Conditions</button>

        <div id="termsBox" style="display: none;">
            <h1>Algemene voorwaarden</h1>
            <p>Wetgeving in Nederland (en Europa)</p>
            <p>De Nederlandse Auteurswet (1912): Copyright ontstaat automatisch bij het creëren van een werk.</p>
            <p>Rechten van de auteur: Het recht om je werk te reproduceren en te verspreiden.</p>
            <p>Bescherming duurt tot 70 jaar na de dood van de auteur.</p>
            <p>Software Richtlijn (91/250/EEG): Beschermt softwarecode als een "literaire creatie".</p>
            <p>Database Richtlijn (96/9/EG): Beschermt databanken tegen kopiëren van "substantiële delen".</p>
        </div>

        <button onclick="acceptCookies()">Accept</button>
        <button onclick="rejectCookies()">Reject</button>
    </div>

    </body>
    </html>
    <?php
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chirpify - Login</title>
    <link rel="stylesheet" href="../Main.css">
    <script defer src="Main.js"></script>
</head>
<body>

<div class="container">
   
    <h2>Login</h2>
    <form action="" method = "post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <input type="submit" name="submit" value="Log In"><br>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>


</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username)){
            echo "Please enter your username"; 
        } elseif (empty($password)){
            echo "Please enter your password"; 
        } else {
            $sql = "SELECT user, password, profile_pic, age, bio FROM users WHERE user = '$username'";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $hash = $row["password"];

                if (password_verify($password, $hash)) {

                    $_SESSION['user'] = $row['user'];
                    $_SESSION['profile_pic'] = $row['profile_pic'];
                    $_SESSION['age'] = $row['age'];
                    $_SESSION['bio'] = $row['bio'];

                    echo "Login successful";
                    header("location: post.php");
                    exit;

                } else {
                    echo "<p class = 'error'>Incorrect username or password</p>";
                }
            } else {
                echo "<p class = 'error'>user not found</p>";
                
            }
        }
    }

    mysqli_close($conn);
?>