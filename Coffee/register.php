<?php
session_start();

require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    if (strlen($password) <= 8) {
        $error = "Password must be more than 8 characters.";
    } else {
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $stmt = $db->prepare("SELECT * FROM user WHERE Username = ?");
        $stmt->execute([$username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error = "Username already exists. Please choose a different one.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare("INSERT INTO user (Username, Password) VALUES (?, ?)");

            if ($stmt->execute([$username, $hashed_password])) {
                header("Location: index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again later.";
            }
        }
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
    <title>User Registration</title>
</head>
<body>
    <?php include('nav.php'); ?>

    <a href="index.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </a>

    <div class="loginwrapper">
        <div>
            <img src="images/user.jpg" style="width: 350px; height: auto; border-radius: 25px;">
        </div>

        <div class="form-container">
            <h2>Sign Up</h2><br>
            <!-- Error Display -->
            <?php if(isset($error)): ?>
                <div style="color: red;"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="signup.php" method="POST">
                <input type="hidden" name="register">
                <div class="input-container">
                    <label for="Username">Username:</label>
                    <input type="text" id="Username" name="Username" required>
                </div>
                <div>
                    <label for="Password">Password:</label>
                    <input type="password" id="Password" name="Password" required>
                </div>
                <div>
                    <input type="submit" value="Register">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
