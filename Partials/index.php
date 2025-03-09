<?php
<<<<<<< HEAD
session_start();
=======
global $conn;
error_reporting(E_ALL);
ini_set('display_errors', 1);


>>>>>>> f034c64 (V.0.0.0)
include "header.php";
include "database.php";

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
    exit();
}
?>
    <div class="container">
   
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>

</body>
</html>