<?php
require('connection.php');
require('authentication.php');

if ($_POST && !empty($_POST['Type'])) {
    $Type = filter_input(INPUT_POST, 'Type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $query = "INSERT INTO category (Type) VALUES (:Type)";
    $statement = $db -> prepare($query);

    $statement ->bindValue (':Type', $Type);

    if ($statement -> execute()) {
        echo "Success";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta Type="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Coffee Shop</title>
    <link rel="stylesheet" href="pretty.css">
</head>
<body>
<?php include('nav.php'); ?>

<a href="profile.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </a>

<div class="container">
    <h1>New Category</h1>
    <form class="coffeeShopForm" action="type.php" method="POST">
    <label for="Type">Type:</label>
    <input type="text" id="Type" name="Type"><br>

    <button type="submit">Add Category</button>
</form>
</div>
</body>
</html>
