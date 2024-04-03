<?php
require('connection.php');
require('authentication.php');

// Function to validate category details
function isValidCategory($type) {
    return strlen($type) >= 1;
}

// Delete category
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_category"])) {
    // Sanitize and get the category ID
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "DELETE FROM category WHERE type_id = :type_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $id, PDO::PARAM_INT);

    // Execute the DELETE.
    $statement->execute();

    // Redirect after deletion.
    header("Location: index.php");
    exit;
}

// UPDATE category if Type and id are present in POST.
if ($_POST && isset($_POST['Type']) && isset($_POST['id'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $type  = filter_input(INPUT_POST, 'Type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Validate category details
    if (isValidCategory($type)) {
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query = "UPDATE category SET type = :Type WHERE type_id = :type_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Type', $type);
        $statement->bindValue(':type_id', $id, PDO::PARAM_INT);

        // Execute the UPDATE.
        $statement->execute();

        // Redirect after update.
        header("Location: index.php?id={$id}");
        exit;
    } else {
        $error_message = "Invalid category details. Please make sure all fields are filled out.";
    }
} elseif (isset($_GET['id'])) { // Retrieve category to be edited if id GET parameter is in URL.
    // Sanitize the id.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM category WHERE type_id = :type_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':type_id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $category = $statement->fetch();
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
    <title>Edit Category</title>
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
            <input type="hidden" name="id" value="<?= $category['type_id'] ?>"><br>
            
            <label for="Type">Type</label>
            <input type="text" id="Type" name="Type" value="<?= $category['type'] ?>"><br>
            
            <button type="submit" value="Update">Update</button>
            <button type="submit" name="delete_category" value="Delete" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
        </form>
    <?php endif ?>
</div>
</body>
</html>
