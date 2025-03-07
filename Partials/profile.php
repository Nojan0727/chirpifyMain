<?php
    session_start();

    $username = $_SESSION['user'] ?? '';
    $age = $_SESSION['age'] ?? 'N/A';
    $bio = $_SESSION['bio'] ?? 'No bio available';
    $profile_picture = $_SESSION['profile_picture'] ?? 'default-profile.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chirpify</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>
<body>

<div class="headerSami">
    <div class="leftHeader">
        <li><a href="#"><img class="chirpifyLogo" src="Image/Chripify.png" alt=""> <h3>Chirpify</h3></a></li>
    </div>

    <div class="middleHeader">
       <li class = "huy"><a href=""></a><i class="fa-solid fa-arrow-left"></i></li>
        <h2><?php echo $username; ?> </h2>
    </div>

    <div class="rightHeader">
    <form action="" method="GET">
            <label>
                <input type="text" name="query" style="color: white;" placeholder="Looking for something?">
            </label>
            <button class="searchButton" type="submit">Search</button>
    </form>

        <?php
        if (isset($_GET['query'])) {
            $searchTerm = htmlspecialchars($_GET['query']);
            echo "<p class= 'searchQuery'>You searched for: <strong>" . $searchTerm . "</strong></p>";
        }
        ?>

</div>

<nav class="navBar">
    <ul>
        <li><a href="post.php"><i class="fa-solid fa-house"></i> <span>Home</span></a></li>
        <li><a href="#"><i class="fas fa-search"></i> <span>Search</span></a></li>
        <li><a href="#"><i class="fa-regular fa-compass"></i> <span>Explore</span></a></li>
        <li><a href="#"><i class="fa-regular fa-bell"></i> <span>Messages</span></a></li>
        <li><a href="#"><i class="fa-regular fa-envelope"></i> <span>Notification</span></a></li>
        <li><a href="#"><i class="fa-regular fa-square-plus"></i> <span>Create</span></a></li>
        <li><a href="profile.php"><i class="fa-regular fa-user"></i> <span>Profile</span></a></li>
        <li class="down"><a href="#"><i class="fas fa-crown"></i><span>Premium</span></a></li>
        <li class="down"><a href="#"><i class="fa fa-bars"></i><span>More</span></a></li>
        <li class="down"><a href="index.php"><i class="fa-solid fa-right-from-bracket"></i><span>Log out</span></a></li>
    </ul>
</nav>

<div class ="profileBody">

</div>

</body>
</html>

<?php
    
?>

