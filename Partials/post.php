<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
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
        <!-- FIX: Added correct form action & method -->
        <form action="" method="GET">
            <label>
                <input type="text" name="query" style="color: white;" placeholder="Looking for something?">
            </label>
            <button class="searchButton" type="submit">Search</button> <!-- FIX: Added a search button -->
        </form>

        <?php
        if (isset($_GET['query'])) {
            $searchTerm = htmlspecialchars($_GET['query']);
            echo "<p class= 'searchQuery'>You searched for: <strong>" . $searchTerm . "</strong></p>";
        }
        ?>

    </div>
</div>
<nav class="navBar">
    <ul>
        <li><a href="#"><i class="fa-solid fa-house"></i> <span>Home</span></a></li>
        <li><a href="#"><i class="fas fa-search"></i> <span>Search</span></a></li>
        <li><a href="#"><i class="fa-regular fa-compass"></i> <span>Explore</span></a></li>
        <li><a href="#"><i class="fa-regular fa-bell"></i> <span>Messages</span></a></li>
        <li><a href="#"><i class="fa-regular fa-envelope"></i> <span>Notification</span></a></li>
        <li><a href="#"><i class="fa-regular fa-square-plus"></i> <span>Create</span></a></li>
        <li><a href="#"><i class="fa-regular fa-user"></i> <span>Profile</span></a></li>
        <li class="down"><a href="#"><i class="fas fa-crown"></i><span>Premium</span></a></li>
        <li class="down"><a href="#"><i class="fa fa-bars"></i><span>More</span></a></li>
    </ul>
</nav>

<div class="body">
    <div class="happening">
        <img class="profileImg" src="image/profileimg.png" alt="">

        <!-- FIX: Corrected action URL -->
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <label class="happeningLabel">
                <textarea name="content" placeholder="What's Happening!?" required></textarea>
            </label>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Post!</button>
        </form>

        <h2 class="post">Recent Posts</h2>
        <?php if (!empty($_SESSION['posts'])): ?>
            <?php foreach (array_reverse($_SESSION['posts']) as $index => $post): ?>
                <div class="post">
                    <p><strong><?php echo htmlspecialchars($post['user']); ?>:</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="max-width: 300px;">
                    <?php endif; ?>

                    <p>
                        <!-- Like Icon -->
                        <i class="fa-regular fa-heart like-icon" data-index="<?php echo $index; ?>"></i>
                        <span id="like-count-<?php echo $index; ?>"><?php echo $post['likes']; ?></span>

                        <!-- Repost Icon -->
                        <i class="fa-solid fa-retweet repost-icon" data-index="<?php echo $index; ?>"></i>
                        <span id="repost-count-<?php echo $index; ?>"><?php echo $post['reposts']; ?></span>
                    </p>
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

</body>
</html>