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
    <link rel="stylesheet" href="pretty.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <main>
        <section class="search-section">
        </section>
        <section class="posts">
            <!-- Display coffee shop listings dynamically from the database -->
            <?php while($row = $statement->fetch()): ?>
                <div class="coffee-shop-card">
                    <div class="coffee-shop">
                        <h3><a href="show.php?id=<?= $row['Shop_id']?>"><?= $row['Name'] ?></h3>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>
    </main>
    <script src="functions.js"></script>
    <footer>
        <p>&copy; 2024 Coffee Shop Guide CMS. All rights reserved.</p>
    </footer>
</body>
</html>