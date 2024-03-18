<?php
require('connection.php');
require('authentication.php');

if ($_POST && !empty($_POST['Name']) && !empty($_POST['Hours'])&& !empty($_POST['Website'])&& !empty($_POST['Description'])) {
    $name = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'Location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hours = filter_input(INPUT_POST, 'Hours', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $website = filter_input(INPUT_POST, 'Website', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO cafe (name, location, hours, website, description) VALUES (:Name, :Location, :Hours, :Website, :Description)";
    $statement = $db -> prepare($query);

    $statement ->bindValue (':Name', $name);
    $statement ->bindValue ('Location', $location);
    $statement ->bindValue ('Hours', $hours);
    $statement ->bindValue (':Website', $website);
    $statement ->bindValue (':Description', $description);

    if ($statement -> execute()) {
        echo "Success";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Coffee Shop</title>
    <link rel="stylesheet" href="beautify.css">
</head>
<body>
<?php include('nav.php'); ?>
<div class="container">
    <h1>Add New Coffee Shop</h1>
    <form class="coffeeShopForm" action="admin.php" method="POST">
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name"><br>

        <label for="Location">Location:</label>
        <input type="text" id="Location" name="Location"><br>

        <label for="Hours">Hours:</label>
        <input type="text" id="Hours" name="Hours"><br>

        <label for="Website">Website:</label>
        <input type="text" id="Website" name="Website"><br>

        <label for="Description">Description:</label><br>
        <textarea id="Description" name="Description" rows="4"></textarea><br>

        <button type="submit">Add Coffee Shop</button>
    </form>
</div>
</body>
</html>
