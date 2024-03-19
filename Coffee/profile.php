<?php
require('connection.php');
require('authentication.php');

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
    
    <section class="manage">
        <!-- Display coffee shop listings dynamically from the database -->

        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'manage')">Manage</button>
            <button class="tablinks" onclick="window.location.href = 'admin.php';">Add New Shop</button>
        </div>

        <div>
            <table class="info"> <!-- Updated class name to "info" -->
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $statement->fetch()): ?>
                    <tr>
                        <td><?= $row['Name'] ?></td>
                        <td class="edit"><a href="update.php?id=<?= $row['Shop_id'] ?>"><button>Edit</button></a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
    <script src="functions.js"></script>
    <footer>
        <p>&copy; 2024 Coffee Shop Guide CMS. All rights reserved.</p>
    </footer>
</body>
</html>