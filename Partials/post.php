<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("database.php");
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}



$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['content'])) {
    $content = trim($_POST['content']);
    $image_path = "";

    if (!empty($_FILES['image']['name'])) {
        $file_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }
    $post_posted_at = date('Y-m-d H:i');
    $sql = "INSERT INTO posts (post_text, user_id, post_created_at, images)
            VALUES (:post_text, :user_id, :post_created_at, :images)";

    $binding = $conn->prepare($sql);
    $binding->bindParam(':post_text', $content);
    $binding->bindParam(':user_id', $_SESSION['id']);
    $binding->bindParam(':post_created_at', $post_posted_at);
    $binding->bindParam(':images', $image_path);
    $binding->execute();

    $post_id = $conn->lastInsertId();
    $_SESSION['last_post_id'] = $post_id;

    $_SESSION['posts'][] = [
        'post_id' => $post_id,
        'user_id' => $_SESSION['id'],
        'content' => $content,
        'image' => $image_path,
        'post_created_at' => $post_posted_at,
        'profile_pic' => $_SESSION['profile_pic'],
        'user' => $_SESSION['user'],
        'likes' => 0,
        'reposts' => 0
    ];

            

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
    <div class="happening">
        <img class="profileImg" src="<?php echo $_SESSION['profile_pic']; ?>" alt="">

        <form class="form" action="" method="post" enctype="multipart/form-data">
            <label class="happeningLabel">
                <textarea name="content" placeholder="What's Happening!?" required></textarea>
            </label>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Post!</button>
        </form>

        <div style="position: relative; border-bottom: 1px solid rgb(70, 70, 70); height: 0 ;">
            <h2 class="recentPost">Recent Posts</h2>
            
        </div>

        <div id="darkEffect" class="darkEffect">d</div>

        
        

        <?php if (!empty($_SESSION['posts'])): ?>
    <?php foreach (array_reverse($_SESSION['posts']) as $index => $post): ?>
        <div class="post">

            <p class = "postedAt"><?php echo $post["post_created_at"]; ?></p>
            <p class="names">
                <img class="postImg" src="<?php echo isset($post['profile_pic']) ? $post['profile_pic'] : ''; ?>" >
                <strong><?php echo isset($post['user']) ? htmlspecialchars($post['user']) : ''; ?></strong>
                <span>@<?php echo isset($post['user']) ? htmlspecialchars($post['user']) : ''; ?></span>
            </p>

            <p class="content">
                <?php echo isset($post['content']) ? nl2br(htmlspecialchars($post['content'])) : ''; ?>
            </p>

            <p class="postedImg">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo isset($post['image']) ? htmlspecialchars($post['image']) : ''; ?>" alt="Image" 
                    style="max-width: 500px;  border-radius: 15px; min-width:500px; max-height: 300px; object-fit:cover; object-position: center;">
                <?php endif; ?>
            </p>

            <p class="likes">
                <span class="like">
                    <i class="fa-regular fa-heart like-icon" data-index="<?php echo $index; ?>"></i>
                    <span id="like-count-<?php echo $index; ?>"><?php echo isset($post['likes']) ? $post['likes'] : 0; ?></span>
                </span>

                <span class="repost">
                    <i class="fa-solid fa-retweet repost-icon" data-index="<?php echo $index; ?>"></i>
                    <span id="repost-count-<?php echo $index; ?>"><?php echo isset($post['reposts']) ? $post['reposts'] : 0; ?></span>
                </span>

                <span class="commentBlock" onclick="INVcommentForm(event, <?php echo $index ?>)">
                    <span><i class="fa-solid fa-comment"></i> </span>
                </span>
            </p>

            <?php 
            $sql = "INSERT INTO likes (user_id, post_id)
                    VALUES (:user_id, :post_id)";
            $binding = $conn->prepare($sql);
            $binding->bindParam(':user_id', $_SESSION['id']);
            $binding->bindParam(':post_id', $post['post_id']);
            $binding->execute(); 
            ?>

            <form action=""></form>

            <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_comment']) && $_POST['post_id'] == $post['post_id']) {
                $comment_posted_at = date('Y-m-d H:i:s');
                $sql = "INSERT INTO comments (comment_text, post_id, user_id, comment_posted_at)
                        VALUES (:comment_text, :post_id, :user_id, :comment_posted_at)";
                $binding = $conn->prepare($sql);
                $binding->bindParam(':comment_text', $_POST['comment_text']);
                $binding->bindParam(':post_id', $post['post_id']);
                $binding->bindParam(':user_id', $_SESSION['id']);
                $binding->bindParam(':comment_posted_at', $comment_posted_at);
                $binding->execute();

                echo "<p style='color:lightgreen; width:200px;'>Comment posted</p>";

                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
            ?>

            <?php 
            $sql = "SELECT comments.*, users.user, users.profile_pic " .
                    "FROM comments " .
                    "JOIN users ON comments.user_id = users.id " .
                    "WHERE comments.post_id = :post_id " .
                    "ORDER BY comment_posted_at ASC";

            $binding = $conn->prepare($sql);
            $binding->bindParam(':post_id', $post['post_id']);
            $binding->execute();
            $comments = $binding->fetchAll(PDO::FETCH_ASSOC);

            foreach ($comments as $comment) {
                echo "<div class='comment'>";
                echo "<p class='commentedAt'>" . $comment['comment_posted_at'] . "</p>";
                echo '<img class = "commentProfile" src="' . $comment["profile_pic"] . '" alt="">';
                echo '<strong>' . $comment["user"] . '</strong>';
                echo "<span>@{$comment['user']}</span>";if ($post['user'] === $comment['user']){
                    echo '<div class = "admin" >Creator</div>';
                }
                echo "<p>{$comment['comment_text']}</p>";
                echo "</div>";
            }

            

            
            ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="commentForm" id="<?php echo "commentform" . $index ?>" style="display:none;" method="post">
                <span class="commentBlock" onclick="INVcommentForm(event, <?php echo $index ?>)">
                    <span><i class="fa-solid fa-x"></i> </span>
                </span>
                <label class="commentPro" for="">
                    <img src="<?php echo $_SESSION["profile_pic"]; ?>" alt=""> <strong> <?php echo $_SESSION["user"]; ?> </strong>
                    <p><?php echo "@" . $_SESSION["user"]; ?></p>
                    <textarea name="comment_text" id="comment_text" placeholder="Post your reply" required></textarea>
                </label>
                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                <button name="post_comment">Post</button>
            </form>

        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="post">No posts yet.</p>
<?php endif; ?>

    </div>
</div>

<script src="Main.js"></script>

</body>
</html>
