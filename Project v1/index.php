<?php
require('connection.php');

// SQL query to fetch all rows from the coffee_shops table
$query = "SELECT * FROM coffee_shop";
$statement = $db->prepare($query);
$statement->execute();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Guide CMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('nav.php'); ?>
    <main>
        <section>
            <h2>Welcome to the Coffee Shop Guide</h2>
            <p>Discover the best coffee shops around!</p>
        </section>
        <section>
            <form action="search.php" method="GET">
                <input type="text" id="search" name="search" placeholder="Enter keyword...">
                <button type="submit">Search</button>
            </form>
        </section>
        <section>
            <!-- Display coffee shop listings dynamically from the database -->
            <!-- Example: -->
            <div class="coffee-shop">
                <h3>Coffee Shop Name</h3>
                <p>Location: XYZ Street</p>
                <p>Hours: 8:00 AM - 6:00 PM</p>
                <!-- Add more details as necessary -->
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Coffee Shop Guide CMS. All rights reserved.</p>
    </footer>
</body>
</html>
