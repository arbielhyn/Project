<?php
require('connection.php');

// Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database based on the username
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->execute(array(':username' => $username));
    $user = $statement->fetch();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Set session variable to indicate user is logged in
        session_start();
        $_SESSION['username'] = $username;
        // Redirect to dashboard or user profile page
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password";
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
    <title>User Registration and Login</title>
</head>
<body>
    <?php include('nav.php'); ?>

    <div class="loginwrapper">
    <div>
        <img src="images/user.jpg" style="width: 350px; height: auto; border-radius: 25px;">
    </div>

    <div class="form-container">
        <div>
            <h2>Log In</h2><br>
            <form action="register.php" method="POST">
                <input type="hidden" name="login">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <input type="submit" value="Login">
                </div>
            </form>
        </div>
        <div>
        <p>or <a href="signup.php">sign up</a></p>
        </div>
    </div>
    </div>
</body>
</html>
