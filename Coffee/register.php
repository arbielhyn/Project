<?php
// Start session
session_start();
 
// Database connection
require('connection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
 
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['confirm_password']; // Corrected field name
 
    // Validate input lengths
    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Sanitize inputs
        $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);
 
        // Check if username already exists
        $stmt = $db->prepare("SELECT * FROM user WHERE Username = ?");
        $stmt->execute([$username]);
        $existing_user = $stmt->fetch();
 
        if ($existing_user) {
            $error = "Username already exists. Please choose a different one.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 
            // Prepare SQL statement
            $stmt = $db->prepare("INSERT INTO user (Username, Password) VALUES (?, ?)");
 
            // Execute the statement
            $success = $stmt->execute([$username, $hashed_password]);
 
            if ($success) {
                $success_message = "Account created successfully!";
                header("Location: login.php");
            } else {
                $error = "Registration failed. Please try again later.";
            }
        }
    }
}
?>
