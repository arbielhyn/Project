<?php
require('connection.php');

if (isset($_GET['id'])) { // Change 'shop_id' to 'id'
    $shopId = $_GET['id']; // Change variable name from $postId to $shopId
    $query = "SELECT * FROM cafe WHERE Shop_id = :Shop_id"; // Change 'id' to 'Shop_id'
    $statement = $db->prepare($query);
    $statement->bindParam(':Shop_id', $shopId); // Change ':Shop_id' to '$shopId'
    $statement->execute();

    $row = $statement->fetch();
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
        <img class="coffeeimg" src="images/placeholder.jpeg" style="width: 450px; height: auto; border-radius: 25px;">
            <h3><?= $row['Name'] ?></h3><br>
            <p><?= $row['Description'] ?></p>
        </div>
        <?php else: ?>
        <p>No coffee shop found with the provided ID.</p>
        <?php endif; ?>

        <div class="comments">
    <h3>Comments</h3>
    <form action="submit_comment.php" method="POST">
        <input type="hidden" name="shop_id" value="<?= $shopId ?>">
        <div class="comment-container">
            <textarea class="comment-textarea" name="comment" rows="2" cols="50" placeholder="Write your comment here"></textarea>
            <button type="submit" class="comment-button"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 15">
  <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z"/>
</svg></button>
        </div>
    </form>
</div>
    </div>

    <footer>
        <p>&copy; 2024 Coffee Shop Guide CMS. All rights reserved.</p>
    </footer>
</body>
</html>
