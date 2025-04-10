<?php
global $conn;
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("database.php");

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$current_user = $_SESSION['user'];
$recipient = $_GET['user'] ?? null;

$sql = $conn->prepare("SELECT user, profile_pic FROM users WHERE user != :current_user");
$sql->bindParam(':current_user', $current_user);
$sql->execute();
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="messagePage">
        <div class="chatSidebar">
            <h4>Users</h4>
            <ul class="userList">
                <?php foreach ($users as $user): ?>
                    <li>
                        <a class="chatUser" href="message.php?user=<?= htmlspecialchars($user['user']) ?>">
                            <img src="<?= htmlspecialchars($user['profile_pic']) ?>" alt="">
                            <div>
                                <strong><?= htmlspecialchars($user['user']) ?></strong>
                                <span>@<?= htmlspecialchars($user['user']) ?></span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="chatArea">
            <?php if ($recipient): ?>
                <div class="chatHeader">
                    <h3>Chat with @<?= htmlspecialchars($recipient) ?></h3>
                </div>
                <div class="chatBox">
                    <!-- Dummy messages -->
                    <div class="chatMessage received"><p>Damn, you nail it!</p></div>
                    <div class="chatMessage sent"><p>Yeee!</p></div>
                </div>
                <form method="POST" class="chatForm">
                    <input type="hidden" name="to_user" value="<?= htmlspecialchars($recipient) ?>">
                    <input type="text" name="message_text" placeholder="Write a message..." required>
                    <button type="submit" name="send_message">Send</button>
                </form>
            <?php else: ?>
                <p class="selectUserMsg">Please select a user to start chatting.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $to_user = $_POST['to_user'];
    $message = trim($_POST['message_text']);
    echo "<script>alert('Message sent to @$to_user!'); window.location.href='message.php?user=$to_user';</script>";
    exit;
}
?>
</body>
</html>
