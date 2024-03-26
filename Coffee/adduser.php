<?php
require('connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $user_type = htmlspecialchars($_POST['user_type']);

    // Hash the password before storing it in the database for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute a SQL statement to insert the new user into the database
    $sql = "INSERT INTO user (Username, Password, User_type) VALUES (:username, :password, :user_type)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // User added successfully
        echo "User added successfully.";
        header("Location: profile.php");
        exit; // Add an exit statement after header redirection
    } else {
        // Error occurred while adding the user
        echo "Error adding user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pretty.css">
    <title>Add New User</title>
</head>
<body>
    <?php include('nav.php'); ?>

    <a href="profile.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </a>

    <div class="container">
        <h2>Add New User</h2>
        <form class="coffeeShopForm" action="adduser.php" method="POST"> <!-- Change action to adduser.php -->
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <label for="user_type">User Type:</label><br>
            <select name="user_type" id="user_type">
                <option value="regular">Regular</option>
                <option value="admin">Admin</option>
            </select><br><br>
            <input type="submit" value="Add User">
        </form>
    </div>
</body>
</html>
