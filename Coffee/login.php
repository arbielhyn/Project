<?php
session_start();
include ('connection.php');

$login_error = ""; // Initialize login error message

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
        $_SESSION['user_type'] = $user['user_type']; // Capitalize 'Username' to match database column name

        // Set login success session variable
        $_SESSION['login_success'] = true;
         

        if (strtolower($user['user_type']) == 'admin') {header('Location: index.php');}
        else {header('Location: login.php'); exit;}
        // Redirect to index.php or any other authenticated page
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
                <div id="login">
                <h2>Log In</h2>
                <p>New around here? <a href="register.php">sign up</a> and be part of the community</p>
                </div>
                <!-- Display login error message if any -->
                <?php if (!empty($login_error)): ?>
                    <p style="color: red;"><?php echo $login_error; ?></p>
                <?php elseif (isset($_SESSION['login_success']) && $_SESSION['login_success']): ?>
                    <p style="color: green;">Login successful!</p>
                <?php endif; ?>
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
        </div>
    </div>
</body>
</html>
