<?php
require('connection.php');

     // SQL is written as a String.
     $query = "SELECT * FROM cafe";

     // A PDO::Statement is prepared from the query.
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute().
     $statement->execute(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Guide CMS</title>
    <link rel="stylesheet" href="beautify.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <main>
        <section class="search-section">
            <div class="search">
            <form action="search.php" method="GET">
                <input type="text" id="search" name="search" placeholder="Enter keyword...">
                <button type="submit">Search</button>
            </form>
            </div>
        </section>
        <section>
            <!-- Display coffee shop listings dynamically from the database -->
            <?php while($row = $statement -> fetch()):  ?>
            <div id="posts">
            <div class="coffee-shop">
                <h3><?= $row['Name'] ?></h3>
                <p>Hours: <?= $row['Hours'] ?></p>
                <p>Website: <a href="<?= $row['Website'] ?>" target="_blank"><?= $row['Website'] ?></a></p>
                <p>Description: <?= substr($row['Description'], 0, 50) . (strlen($row['Description']) > 50 ? "..." : "") ?></p>
                <!-- Add more details as necessary -->
            </div>
                </div>
            <?php endwhile; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Coffee Shop Guide CMS. All rights reserved.</p>
    </footer>
</body>
</html>
