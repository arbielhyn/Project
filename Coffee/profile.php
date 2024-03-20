<?php
require('connection.php');
require('authentication.php');

// First query to select data from the "cafe" table
$query_cafe = "SELECT * FROM cafe";
$statement_cafe = $db->prepare($query_cafe);
$statement_cafe->execute();

// Second query to select data from the "category" table
$query_category = "SELECT * FROM category";
$statement_category = $db->prepare($query_category);
$statement_category->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pretty.css">
    <title>Edit Coffee Shop</title>
    <style>
        /* Hide initially */
        .info {
            display: none;
        }
    </style>
</head>
<body>
    <?php include('nav.php'); ?>

    <a href="index.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </a>
    
    <section class="manage">
        <div class="tab">
            <button class="tablinks" onclick="toggleTable('cafeTable')">Show Cafe</button>
            <button class="tablinks" onclick="toggleTable('categoryTable')">Show Category</button>
        </div>

        <div>
            <table class="info" id="cafeTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th colspan="2"> <!-- Span across two columns -->
                            <a href="coffee.php" class="add-button">+ Add</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $statement_cafe->fetch()): ?>
                    <tr>
                        <td><?= $row['Name'] ?></td>
                        <td class="edit"><a href="update.php?id=<?= $row['Shop_id'] ?>"><button>Edit</button></a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <table class="info" id="categoryTable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th colspan="2"> <!-- Span across two columns -->
                            <a href="type.php" class="add-button">+ Add</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $statement_category->fetch()): ?>
                    <tr>
                        <td><?= $row['type'] ?></td>
                        <td class="edit"><a href="update.php?id=<?= $row['type_id'] ?>"><button>Edit</button></a></td>
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
    <script>
        function toggleTable(tableId) {
            var tables = document.querySelectorAll('.info');
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.display = "none";
            }
            var table = document.getElementById(tableId);
            table.style.display = "block";
        }
    </script>
</body>
</html>
