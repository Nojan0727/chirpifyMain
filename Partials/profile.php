<?php
session_start();
<<<<<<< HEAD
require("database.php");
=======
>>>>>>> origin/main
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
        <div class="profile">
            <div class="banner">
                <img src="<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="Profile Picture" class="profilePic">
            </div>
            <div class="userInfo">
                <div class="username">
                    <h2><?php echo htmlspecialchars($_SESSION['user']); ?></h2>
                    <span class="handle">@<?php echo htmlspecialchars($_SESSION['user']); ?></span>
                </div>
                <p class="bio"><?php echo htmlspecialchars($_SESSION['bio']); ?></p>
                <div class="stats">
                    <span><strong>150</strong> Followers</span>
                    <span><strong>90</strong> Following</span>
                </div>
                <button class="editBtn">Edit Profile</button>
            </div>

<<<<<<< HEAD
            <?php 

            ?>

            <form action="profile.php" method = "post">
                <label for="">name</label>

            </form>

            <div class="tabs">
                <button class="buttonTab active">Posts</button>
                <button class="buttonTab">Replies</button>
                <button class="buttonTab">Media</button>
                <button class="buttonTab">Likes</button>
            </div>

=======
            <div class="tabs">
                <button class="buttonTab active">Posts</button>
                <button class="buttonTab">Replies</button>
                <button class="buttonTab">Media</button>
                <button class="buttonTab">Likes</button>
            </div>

>>>>>>> origin/main
            <div class="posts">
                <?php $posts = $_SESSION['posts'] ?? []; ?>
                <?php foreach ($posts as $index => $post): ?>
                    <?php if ($post['user'] === $_SESSION['user']): ?>
                        <div class="post">
                            <p class="postContent"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                            <?php if (!empty($post['image']) && file_exists($post['image'])): ?>
                                <img src="<?php echo htmlspecialchars($post['image']); ?>" style="max-width: 500px; border-radius: 15px;" alt="Post Image">
                            <?php endif; ?>
                            <div class="postActions">
                                <span><i class="fa-regular fa-heart"></i> <?php echo $post['likes'] ?? 0; ?></span>
                                <span><i class="fa-solid fa-retweet"></i> <?php echo $post['reposts'] ?? 0; ?></span>
                                <form action="" method="post" style="display:inline;">
                                    <button class="deleteBtn" type="submit" name="deletePost" value="<?php echo $index; ?>">
                                        <i class="fa-solid fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (empty(array_filter($posts, fn($p) => $p['user'] === $_SESSION['user']))): ?>
                    <p class="post">No posts yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
