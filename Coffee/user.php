<?php
require('connection.php');
require('authentication.php');

// Function to validate coffee user details
function isValidCoffeeuser($username, $password) {
    return strlen($username) >= 1 && strlen($password) >= 1;
}

// Delete coffee user
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_user"])) {
    // Sanitize and get the coffee user ID
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "DELETE FROM user WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $id, PDO::PARAM_INT);

    // Execute the DELETE.
    $statement->execute();

    // Redirect after deletion.
    header("Location: index.php");
    exit;
}

// UPDATE coffee user if Username, Password, id, and UserType are present in POST.
if ($_POST && isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['id']) && isset($_POST['UserType'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $username  = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userType = filter_input(INPUT_POST, 'UserType', FILTER_SANITIZE_STRING);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Validate coffee user details
    if (isValidCoffeeuser($username, $password)) {
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query = "UPDATE user SET Username = :Username, Password = :Password, user_type = :UserType WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Username', $username);
        $statement->bindValue(':Password', $password);
        $statement->bindValue(':UserType', $userType);
        $statement->bindValue(':user_id', $id, PDO::PARAM_INT);

        // Execute the UPDATE.
        $statement->execute();

        // Redirect after update.
        header("Location: index.php?id={$id}");
        exit;
    } else {
        $error_message = "Invalid coffee user details. Please make sure all fields are filled out.";
    }
} elseif (isset($_GET['id'])) { // Retrieve coffee user to be edited if id GET parameter is in URL.
    // Sanitize the id.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM user WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $user = $statement->fetch();
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
    <title>Edit Coffee User</title>
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
            <input type="hidden" name="id" value="<?= $user['user_id'] ?>"><br>
            
            <label for="Username">Username</label>
            <input type="text" id="Username" name="Username" value="<?= $user['Username'] ?>"><br>
            
            <label for="Password">Password</label>
            <input type="text" id="Password" name="Password" value="<?= $user['Password'] ?>"><br>

            <label for="UserType">User Type</label>
            <select id="UserType" name="UserType">
                <option value="regular" <?= ($user['user_type'] === 'regular') ? 'selected' : '' ?>>Regular</option>
                <option value="admin" <?= ($user['user_type'] === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select><br>
            
            <button type="submit" value="Update">Update</button>
            <button type="submit" name="delete_user" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
        </form>
    <?php endif ?>
</div>
</body>
</html>
