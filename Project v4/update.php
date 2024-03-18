<?php
require('connection.php');
require('authentication.php');

// Function to validate coffee shop details
function isValidCoffeeShop($name, $hours, $website, $description) {
    return strlen($name) >= 1 && strlen($hours) >= 1 && strlen($website) >= 1 && strlen($description) >= 1;
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

// UPDATE coffee shop if Name, Hours, Website, Description, and id are present in POST.
if ($_POST && isset($_POST['Name']) && isset($_POST['Hours']) && isset($_POST['Website']) && isset($_POST['Description']) && isset($_POST['id'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $name  = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hours = filter_input(INPUT_POST, 'Hours', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $website = filter_input(INPUT_POST, 'Website', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Validate coffee shop details
    if (isValidCoffeeShop($name, $hours, $website, $description)) {
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE cafe SET Name = :Name, Hours = :Hours, Website = :Website, Description = :Description WHERE Shop_id = :Shop_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Name', $name);
        $statement->bindValue(':Hours', $hours);
        $statement->bindValue(':Website', $website);
        $statement->bindValue(':Description', $description);
        $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);

        // Execute the UPDATE.
        $statement->execute();

        // Redirect after update.
        header("Location: index.php?id={$id}");
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
    <link rel="stylesheet" href="beautify.css">
    <title>Edit Coffee Shop</title>
</head>
<body>
    <?php include('nav.php'); ?>

    <div class="container">
    <?php if ($id): ?>
        <?php if ($error_message): ?>
            <p style="color: red;"><?= $error_message ?></p>
        <?php endif ?>
        <form class="coffeeShopForm" method="post">
            <input type="hidden" name="id" value="<?= $shop['Shop_id'] ?>"><br>
            
            <label for="Name">Name</label>
            <input type="text" id="Name" name="Name" value="<?= $shop['Name'] ?>"><br>
            
            <label for="Hours">Hours</label>
            <input type="text" id="Hours" name="Hours" value="<?= $shop['Hours'] ?>"><br>
            
            <label for="Website">Website</label>
            <input type="text" id="Website" name="Website" value="<?= $shop['Website'] ?>"><br>
            
            <label for="Description">Description</label>
            <textarea type="text" id="Description" name="Description" rows="5"><?= $shop['Description'] ?></textarea><br>
            
            <button type="submit" value="Update">Update</button>
            <button type="submit" name="delete_shop" value="Delete" onclick="return confirm('Are you sure you want to delete this coffee shop?');">Delete</button>
        </form>
    <?php endif ?>
    </div>
</body>
</html>
