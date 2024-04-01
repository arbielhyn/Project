<?php
session_start();
require('connection.php');

// Pagination configuration
$itemsPerPage = 4; // Number of items per page

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

    // Pagination logic
    $totalItems = $statement->rowCount();
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    // Adjust the query with pagination
    $query .= " LIMIT $offset, $itemsPerPage";
    $statement = $db->prepare($query);
    $statement->execute(); 
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
    <?php if ($statement->rowCount() == 0) {
        // No search results found
        echo "<p>No search results found.</p>";
    } ?>
    </div>

    <!-- Pagination links -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?search=<?= urlencode($search) ?>&page=<?= $currentPage - 1 ?>">Previous</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="?search=<?= urlencode($search) ?>&page=<?= $i ?>" <?php if ($i === $currentPage) echo 'class="active"' ?>><?= $i ?></a>
        <?php } ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?search=<?= urlencode($search) ?>&page=<?= $currentPage + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
</body>
</html>
