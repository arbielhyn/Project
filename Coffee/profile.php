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
    
    <section class="manage">
        <!-- Display coffee shop listings dynamically from the database -->

        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'manage')">Manage</button>
            <button class="tablinks" onclick="openTab(event, 'manage')"><a href="admin.php">Add New Shop</a></button>
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