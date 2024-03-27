<?php
session_start();
require('connection.php');

// Initialize search results variable
$searchResults = '';

// Check if the search form is submitted
if (isset($_GET['search'])) {
    // Sanitize the search query to prevent SQL injection
    $search = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');

    // Perform SQL query to search for cafes containing the search keyword in their name or description
    $query = "SELECT * FROM cafe WHERE Name LIKE '%$search%' OR Description LIKE '%$search%'";
    $statement = $db->prepare($query);
    $statement->execute(); 
    if ($statement->rowCount() == 0) {
        // No search results found
        echo "<p>No search results found.</p>";
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
    <!-- Display search results -->
    <div class='posts'>
    <?php while ($row = $statement->fetch()): ?>
        <div class='coffee-shop-card'>
            <div class='coffee-shop'>
                <h3><a href='show.php?id=<?= $row['Shop_id'] ?>'><?= $row['Name'] ?></a></h3>
                <p><?= $row['Description'] ?></p>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</body>
</html>
