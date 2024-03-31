<?php
require('connection.php');

// First query to select data from the "cafe" table
$query_cafe = "SELECT * FROM cafe";
$statement_cafe = $db->prepare($query_cafe);
$statement_cafe->execute();

// Second query to select data from the "category" table
$query_category = "SELECT * FROM category";
$statement_category = $db->prepare($query_category);
$statement_category->execute();

// Third query to select data from the "user" table
$query_user = "SELECT * FROM user";
$statement_user = $db->prepare($query_user);
$statement_user->execute();

// Fourth query to select data from the "comment" table
$query_comment = "SELECT comments.*, cafe.Name AS shop_name 
                  FROM comments 
                  INNER JOIN cafe ON comments.shop_id = cafe.Shop_id";
$statement_comment = $db->prepare($query_comment);
$statement_comment->execute();

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

    
    <section class="manage">
        <div class="tab">
            <button class="tablinks" onclick="toggleTable('cafeTable', this)">Show Cafe</button>
            <button class="tablinks" onclick="toggleTable('categoryTable', this)">Show Category</button>
            <?php if (isset($_SESSION['user_type']) && $_SESSION ['user_type'] === 'admin'): ?> <!-- Check if the user is an admin -->
                <button class="tablinks" onclick="toggleTable('userTable', this)">Manage Users</button>
                <button class="tablinks" onclick="toggleTable('commentTable', this)">Manage Comments</button>
            <?php endif ?>
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
                    <tr class="edit-wrapper">
                        <td class="edit-cell"><?= $row['Name'] ?></td>
                        <td class="name-cell"><a href="update.php?id=<?= $row['Shop_id'] ?>"><button>Edit</button></a></td>
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
                        <td class="edit-cell"><?= $row['type'] ?></td>
                        <td class="name-cell"><a href="type.php?id=<?= $row['type_id'] ?>"><button>Edit</button></a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <table class="info" id="userTable">
                <thead>
                    <tr>
                        <th>Users</th>
                        <th colspan="2"> <!-- Span across two columns -->
                            <a href="adduser.php" class="add-button">+ Add</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $statement_user->fetch()): ?>
                    <tr>
                        <td class="edit-cell"><?= $row['Username'] ?></td>
                        <td class="name-cell"><a href="user.php?id=<?= $row['user_id'] ?>"><button>Edit</button></a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <table class="info" id="commentTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Comment</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $statement_comment->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr class="edit-wrapper">
                        <td class="name-cell"><?= $row['shop_name'] ?></td>
                        <td class="edit-cell"><?= $row['comment'] ?></td>
                        <td class="name-cell">
                            <form action="editcomment.php" method="POST">
                                <input type="hidden" name="comment_id" value="<?= $row['comment_id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
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

            window.onload = function() {
                var cafeButton = document.querySelector('.tab button:nth-child(1)');
                toggleTable('cafeTable', cafeButton); // Open cafe table by default when the page loads
            };
        var activeTab = null; // Variable to store the active tab

        function toggleTable(tableId, button) {
            var tables = document.querySelectorAll('.info');
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.display = "none";
            }
            var table = document.getElementById(tableId);
            table.style.display = "block";

            if (activeTab !== null) {
                activeTab.classList.remove('active');
            }

            button.classList.add('active');
            activeTab = button;
        }
    </script>
</body>
</html>