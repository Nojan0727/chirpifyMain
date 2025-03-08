<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chirpify</title>
    <link rel="stylesheet" href="Main.css">
</head>
<body>

<header>
    <div class="logo">
            <img class="chirpifyLogo" src="Image/Chripify.png" alt="Chirpify Logo" <h1 class="logo">Chirpify</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['user'])): ?>

            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

</body>
</html>