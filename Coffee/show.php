<?php
require('connection.php');
session_start();
if (isset($_GET['id'])) {
    $shopId = $_GET['id'];
    $query = "SELECT * FROM cafe WHERE Shop_id = :Shop_id";
    $statement = $db->prepare($query);
    $statement->bindParam(':Shop_id', $shopId);
    $statement->execute();

    $row = $statement->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if(isset($_SESSION['user_id'])) {
        // Check if the comment field is not empty
        if (!empty($_POST['comment'])) {
            // Get shop_id and user_id from the form or session, wherever they are available
            $shopId = $_POST['id']; // Assuming you have this value in your form
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Prepare and execute the SQL query to insert the comment into the database
            $comment = $_POST['comment'];
            $query = "INSERT INTO comments (comment, shop_id, user_id) VALUES (:comment, :shop_id, :user_id)";
            $statement = $db->prepare($query);
            $statement->bindValue(':comment', $comment);
            $statement->bindValue(':shop_id', $shopId);
            $statement->bindValue(':user_id', $userId);
            
            if ($statement->execute()) {
                echo "<script>alert('Comment submitted successfully');</script>";
                header("Location: show.php?id=$shopId");
                exit;
            } else {
                echo "<script>alert('Failed to submit comment');</script>";
            }
        }
    } else {
        // Redirect the user to the login page if they are not logged in
        header("Location: login.php");
        exit;
    }
}
// Delete Comment if requested
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_comment'])) {
    $commentId = $_POST['comment_id']; // Get the ID of the comment to be deleted

    // Prepare and execute the SQL query to delete the comment
    $query = "DELETE FROM comments WHERE comment_id = :comment_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':comment_id', $commentId);
    
    if ($statement->execute()) {
        echo "<script>alert('Comment deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete comment');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pretty.css">
    <title>Edit Coffee Shop</title>
</head>
<body>
    <?php include('nav.php'); ?>

    <a href="index.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </a>

    <div class="showcase">
    <?php if(isset($row)): ?>
        <div class="shopinfo">
            <?php if (!empty($row['Image'])): ?>
                <img class="coffeeimg" src="uploads/<?= $row['Image'] ?>" style="width: 450px; height: auto; border-radius: 25px;">
            <?php endif; ?>
            <h3><?= $row['Name'] ?></h3><br>
            <p><?= $row['Description'] ?></p>
        </div>
        <?php endif; ?>

        <div class="comments">
            <h3>Comments</h3><br>
            <!-- Fetch comments for this shop_id from the database -->
            <?php
            $query = "SELECT comments.*, user.username FROM comments INNER JOIN user ON comments.user_id = user.user_id WHERE comments.shop_id = :shop_id ORDER BY comments.created_at DESC";
            $statement = $db->prepare($query);
            $statement->bindValue(':shop_id', $shopId);
            $statement->execute();
            $comments = $statement->fetchAll();
            ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-container">
                    <p><strong><?= $comment['username'] ?>:</strong> <?= $comment['comment'] ?></p>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']) : ?>
                        <form action="show.php?id=<?= $shopId ?>" method="POST">
                            <input type="hidden" name="delete_comment" value="1">
                            <input type="hidden" name="comment_id" value="<?= $comment['comment_id'] ?>">
                            <button type="submit" class="delete-button" style="background-color: transparent; border: none; color: gray;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg></button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <form action="show.php?id=<?= $shopId ?>" method="POST">
                <input type="hidden" name="id" value="<?= $shopId ?>">
                <div class="comment-container">
                    <textarea class="comment-textarea" name="comment" rows="2" cols="50" placeholder="Write your comment here"></textarea>
                    <button type="submit" value="submit" class="comment-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 15">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-7.5-.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Coffee Shop Guide CMS. All rights reserved.</p>
    </footer>
</body>
</html>
