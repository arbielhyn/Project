<?php
require('connection.php');
require('authentication.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to validate coffee shop details
function isValidCoffeeShop($name, $description) {
    return strlen($name) >= 1 && strlen($description) >= 1;
}

// Delete coffee shop
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_shop"])) {
    // Sanitize and get the coffee shop ID
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "DELETE FROM cafe WHERE Shop_id = :Shop_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);

    // Execute the DELETE.
    $statement->execute();

    // Redirect after deletion.
    header("Location: index.php");
    exit;
}

// UPDATE coffee shop if Name, Description, and id are present in POST.
if ($_POST && isset($_POST['Name']) && isset($_POST['Description']) && isset($_POST['id'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $name  = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Validate coffee shop details
    if (isValidCoffeeShop($name, $description)) {
        // Remove image if requested
        if (isset($_POST["removeImage"])) {
            // Retrieve the image file path from the database
            $query = "SELECT Image FROM cafe WHERE Shop_id = :Shop_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);
            $statement->execute();
            $imageFilePath = $statement->fetchColumn();

            // Delete the image file from the file system
            if ($imageFilePath && file_exists($imageFilePath)) {
                unlink($imageFilePath);
            }

            // Update the 'Image' column in the database to remove the image reference
            $query = "UPDATE cafe SET Image = '' WHERE Shop_id = :Shop_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);
            $statement->execute();
        }

        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE cafe SET Name = :Name, Description = :Description WHERE Shop_id = :Shop_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Name', $name);
        $statement->bindValue(':Description', $description);
        $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);

        // Execute the UPDATE.
        $statement->execute();

        // Redirect after update.
        header("Location: profile.php?id={$id}");
        exit;
    } else {
        $error_message = "Invalid coffee shop details. Please make sure all fields are filled out.";
    }
} elseif (isset($_GET['id'])) { // Retrieve coffee shop to be edited if id GET parameter is in URL.
    // Sanitize the id.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM cafe WHERE Shop_id = :Shop_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $shop = $statement->fetch();
} else {
    $id = false; // False if we are not UPDATING or SELECTING.
}
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

    <a href="profile.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </a>

    <div class="container">
    <?php if ($id): ?>
        <?php if ($error_message): ?>
            <p style="color: red;"><?= $error_message ?></p>
        <?php endif ?>
        <form class="coffeeShopForm" method="post">
            <input type="hidden" name="id" value="<?= $shop['Shop_id'] ?>"><br>
            
            <label for="Name">Name</label>
            <input type="text" id="Name" name="Name" value="<?= $shop['Name'] ?>"><br>
            
            <label for="Description">Description</label>
            <textarea type="text" id="Description" name="Description" rows="5"><?= $shop['Description'] ?></textarea><br>

            <input type="checkbox" id="removeImage" name="removeImage">
            <label for="removeImage">Remove Image</label><br>
            
            <button type="submit" value="Update">Update</button>
            <button type="submit" name="delete_shop" value="Delete" onclick="return confirm('Are you sure you want to delete this coffee shop?');">Delete</button>
        </form>
    <?php endif ?>
    </div>
</body>
</html>
