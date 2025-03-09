<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

//data for users
$following = [
    'john_doe' => ['name' => 'John Doe', 'image' => 'image/john_doe.jpg'],
    'jane_smith' => ['name' => 'Jane Smith', 'image' => 'image/jane_smith.jpg'],
    'michael_brown' => ['name' => 'Michael Brown', 'image' => 'image/michael_brown.jpg'],
    'lucy_white' => ['name' => 'Lucy White', 'image' => 'image/lucy_white.jpg']
];

//current user
$current_user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Followers</title>
    <link rel="stylesheet" href="Main.css">
</head>
<body>

<div class="header">
    <div class="leftHeader">
        <li><a href="profile.php"><img class="chirpifyLogo" src="Image/Chripify.png" alt=""> <h3>Chirpify</h3></a></li>
    </div>
    <div class="middleHeader">
        <a href="recommended.php">
            <button>For You</button>
        </a>
        <a href="Followers.php"> <button>Following</button></a>
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
            echo "<p class='searchQuery'>You searched for: <strong>" . $searchTerm . "</strong></p>";
        }
        ?>
    </div>
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

<div class="body">
    <div class="followingList"

        <?php if (count($following) > 0): ?>
            <ul>
                <?php foreach ($following as $username => $user): ?>
                    <li class="follow-item">
                        <img class="profileImg" src="image/profileimg.png"<?php echo htmlspecialchars($user['']); ?>" alt="Profile Picture">
                        <div class="follow-user-info">
                            <p><strong><?php echo htmlspecialchars($user['name']); ?></strong> (@<?php echo htmlspecialchars($username); ?>)</p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>You are not following anyone yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>