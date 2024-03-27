<?php
require('connection.php');

// Fetch categories
$query = "SELECT * FROM category";
$statement = $db->prepare($query);
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
        <!-- Display categories as buttons -->
        <section class="category-buttons">
            <button class="category-button-all"><a href="index.php">All</a></button>
            <?php while($category = $statement->fetch()): ?>
                <button class="category-button" data-category="<?= $category['type_id'] ?>">
                    <?= $category['type'] ?>
                </button>
            <?php endwhile; ?>
        </section>
        
        <section class="posts">
            <!-- Display coffee shop listings dynamically from the database -->
            <?php
            // Fetch cafes along with their associated categories
            $query = "SELECT cafe.*, category.type 
                      FROM cafe 
                      LEFT JOIN category ON cafe.category_id = category.type_id 
                      ORDER BY category.type";
            $statement = $db->prepare($query);
            $statement->execute(); 
            ?>
            <?php while($row = $statement->fetch()): ?>
                <div class="coffee-shop-card" data-category="<?= $row['category_id'] ?>">
                    <div class="coffee-shop">
                        <h3><a href="show.php?id=<?= $row['Shop_id']?>"><?= $row['Name'] ?></a></h3>
                    </div>
                </div>
            <?php endwhile; ?>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.category-button').click(function() {
                var categoryId = $(this).data('category');
                $('.coffee-shop-card').hide();
                $('.coffee-shop-card[data-category="' + categoryId + '"]').show();
            });
        });
    </script>
    <footer>
        <p>&copy; 2024 Coffee Shop Guide CMS. All rights reserved.</p>
    </footer>
</body>
</html>
