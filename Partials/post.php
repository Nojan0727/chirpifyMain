<?php


session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("database.php");





// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Ensure the uploads folder exists
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle new posts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['content'])) {
    $content = trim($_POST['content']);
    $image_path = "";

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $file_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Add post to session
    $_SESSION['posts'][] = [
        'user' => $_SESSION['user'],
        'content' => $content,
        'profile_pic' => $_SESSION['profile_pic'],
        'image' => $image_path,
        'likes' => 0,
        'reposts' => 0
    ];

    // ✅ Prevents duplicate posts on refresh by redirecting
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <button>For You</button>
        <button>Following</button>
    </div>

    <div class="rightHeader">
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <label>
                <input type="text" name="search" style="color: white;" placeholder="Looking for something?">
            </label>
            <button class="searchButton" type="submit">Search</button>
        </form>

        <?php
        if (isset($_GET["search"])) {
            $search = htmlspecialchars($_GET['search']);
            $write = $search;

            $search_result = "SELECT * FROM users WHERE user LIKE  '%$write%' ORDER BY id DESC ";
            $search_test = mysqli_query($conn, $search_result);

            if (mysqli_num_rows($search_test) == 0){
                echo "<p class= 'searchQuery'>No user found with the name <strong>" . $write . "</strong></p>";
            }else {
                while ($check_result = mysqli_fetch_assoc($search_test)) {
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
        <li><a href="#"><i class="fa-regular fa-bell"></i> <span>Messages</span></a></li>
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
        </a></li>

    </ul>
</nav>

<div class="body">
    <div class="happening">
    <img class="profileImg" src="<?php echo $_SESSION['profile_pic']; ?>" alt="">

        <form class="form" action="" method="post" enctype="multipart/form-data">
            <label class="happeningLabel">
                <textarea name="content" placeholder="What's Happening!?" required></textarea>
            </label>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Post!</button>
        </form>


        <div style = "postion: relative; border-bottom: 1px solid rgb(70, 70, 70); height: 0 ;">
        <h2 class="recentPost">Recent Posts</h2>
        </div>

        <div id = "darkEffect" class = "darkEffect">d</div>

        <?php if (!empty($_SESSION['posts'])): ?>
            <?php foreach (array_reverse($_SESSION['posts']) as $index => $post): ?>
                <div class="post">
    <p class="names">
        <img class="postImg" src="<?php echo $post['profile_pic']; ?>" >
        <strong><?php echo htmlspecialchars($post['user']); ?></strong>
        <span>@<?php echo htmlspecialchars($post['user']); ?></span>
    </p>

    <p class="content">
        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </p>

    <p class="postedImg">
        <?php if (!empty($post['image'])): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Image" 
            style="max-width: 500px;  border-radius: 15px; min-width:500px ; max-height: 300px; object-fit:cover;
            object-position: center;">
        <?php endif; ?>
    </p>

    <p class="likes">

        <span class="like">
            <i class="fa-regular fa-heart like-icon" data-index="<?php echo $index; ?>"></i>
            <span id="like-count-<?php echo $index; ?>"><?php echo $post['likes']; ?></span>
        </span>

        <span class="repost">
            <i class="fa-solid fa-retweet repost-icon" data-index="<?php echo $index; ?>"></i>
            <span id="repost-count-<?php echo $index; ?>"><?php echo $post['reposts']; ?></span>
        </span>

        <span class="commentBlock" onclick="INVcommentForm(event, <?php echo $index ?>)">
            <span><i class="fa-solid fa-comment"></i> </span>
        </span>
    </p>

    <form class="commentForm" id="<?php echo "commentform" . $index ?>" style="display:none;" method="post">
        <span class="commentBlock" onclick="INVcommentForm(event, <?php echo $index ?>)">
            <span><i class="fa-solid fa-x"></i> </span>
        </span>
        <label class="commentPro" for="">
            <img src="<?php echo $_SESSION["profile_pic"]; ?>" alt=""> <strong> <?php echo $_SESSION["user"]; ?> </strong>
            <p><?php echo "@" . $_SESSION["user"]; ?></p>
            <textarea name="comment_text" placeholder="Post your reply"></textarea>
        </label>
        <button>Post</button>
    </form>
</div>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="post">No posts yet.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function likePost(index) {
        alert('Liked post ' + index);
    }

    function repost(index) {
        alert('Reposted post ' + index);
    }
</script>

<script src="Main.js"></script>

</body>
</html>