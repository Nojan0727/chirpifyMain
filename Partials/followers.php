<?php
session_start();
require("database.php");
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

//data for users
$following = [
    'john_doe' => ['name' => 'John Doe', 'image' => 'uploads/profilepic.png'],
    'jane_smith' => ['name' => 'Jane Smith', 'image' => 'uploads/profilepic.png'],
    'michael_Tree' => ['name' => 'Michael Tree', 'image' => 'uploads/profilepic.png'],
    'Jenny_Street' => ['name' => 'Jenny Street', 'image' => 'uploads/profilepic.png']
];

//current user
$current_user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Followers</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="headerSami">
    <div class="leftHeader">
        <li><a href="#"><img class="chirpifyLogo" src="Image/Chripify.png" alt=""> <h3>Chirpify</h3></a></li>
</div>

<div class="middleHeader">
    <form action="post.php" method="GET" style="display: inline;">
        <button type="submit" name="type" value="for_you">For You</button>
    </form>
    <form action="followers.php" method="GET" style="display: inline;">
        <button type="submit" name="type" value="following">Following</button>
    </form>
</div>


    <div class="rightHeader">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <label>
                <input type="search" name="search" style="color: white;" placeholder="Looking for something?">
            </label>
        </form>

        <?php
        if (isset($_GET["search"])) {
            $search = htmlspecialchars($_GET['search']);
            $write = "%" . $search . "%";  
        
            
            $search_result = "SELECT * FROM users WHERE user LIKE :write ORDER BY id DESC";
            $binding = $conn->prepare($search_result);  
            $binding->bindParam(':write', $write, PDO::PARAM_STR); 
            $binding->execute(); 
        
        

            if ($binding->rowCount() == 0){
                echo "<p class= 'searchQuery'>No user found with the name <strong>" . $write . "</strong></p>";
            } else {
                while ($check_result = $binding->fetch(PDO::FETCH_ASSOC)) {
                    $profile_pic = $check_result["profile_pic"];
                    $username = $check_result["user"];
                    
                    echo "<div class='searchResult'>";
                    echo "<img class='postImg' src='" . $profile_pic . "' alt='Profile Picture'>";
                    echo "<strong>" . htmlspecialchars($username) . "</strong>";
                    echo "<span>@" . htmlspecialchars($username) . "</span>";
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
</div>
<nav class="navBar">
    <ul>
        <li><a href="post.php"><i class="fa-solid fa-house"></i> <span>Home</span></a></li>
        <li><a href="#"><i class="fas fa-search"></i> <span>Search</span></a></li>
        <li><a href="#"><i class="fa-regular fa-compass"></i> <span>Explore</span></a></li>
        <li><a href="messages.php"><i class="fa-regular fa-bell"></i> <span>Messages</span></a></li>
        <li><a href="#"><i class="fa-regular fa-envelope"></i> <span>Notification</span></a></li>
        <li><a href="#"><i class="fa-regular fa-square-plus"></i> <span>Create</span></a></li>
        <li><a href="profile.php"><i class="fa-regular fa-user"></i> <span>Profile</span></a></li>
        <li class="down"><a href="#"><i class="fas fa-crown"></i><span>Premium</span></a></li>
        <li class="down"><a href="#"><i class="fa fa-bars"></i><span>More</span></a></li>
        <li class="down"><a href="index.php"><i class="fa-solid fa-right-from-bracket"></i><span>Log out</span></a></li>
        <li class= "underPro">
            <a href="#">
                <img src="<?php echo $_SESSION["profile_pic"] ?>" alt=""> 
                <p> <?php echo $_SESSION["user"] ?> </p>
                <span> <?php echo "@" . $_SESSION["user"] ?>  </span>
            </a>
        </li>
    </ul>
</nav>
<div class="body">
    <div class="followingList">
        <?php if (!empty($following)): ?>
            <ul>
                <?php foreach ($following as $username => $user): ?>
                    <li class="followItem">
                        <img class="profileImg" src="<?php echo htmlspecialchars($user['image'] ?? 'assets/image/profileimg.png'); ?>" alt="Profile Picture">
                        <div class="followUserInfo">
                            <p><strong><?php echo htmlspecialchars($user['name']); ?></strong> (@<?php echo htmlspecialchars($username); ?>)</p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>You are not following anyone yet.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
