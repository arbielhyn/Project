<?php
session_start();
require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Sanitize input data
    $username = filter_var($username, FILTER_SANITIZE_STRING);

    // Retrieve user data from the database
    $stmt = $db->prepare("SELECT * FROM user WHERE Username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['Password'])) {
        // Authentication successful, set session variables
        $_SESSION['user_id'] = $user['user_id']; // Use lowercase user_id consistent with the database
        $_SESSION['username'] = $user['Username']; // Capitalize 'Username' to match database column name

        // Redirect to index.php or any other authenticated page
        header("Location: index.php");
        exit();
    } else {
        $login_error = "Invalid username or password.";
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
            <!-- Corrected action to login.php -->
            <form action="login.php" method="POST">
                <input type="hidden" name="login">
                <div>
                    <label for="Username">Username:</label>
                    <input type="text" id="Username" name="Username" required>
                </div>
                <div>
                    <label for="Password">Password:</label>
                    <input type="password" id="Password" name="Password" required>
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
