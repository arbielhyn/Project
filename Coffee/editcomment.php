<?php
require('connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if the comment_id is set and not empty
if(isset($_POST['comment_id']) && !empty($_POST['comment_id'])) {
    // Get the comment_id from the POST data
    $comment_id = $_POST['comment_id'];

    // Prepare and execute a SQL statement to delete the comment from the database
    $sql = "DELETE FROM comments WHERE comment_id = :comment_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the deletion was successful
    if($stmt->rowCount() > 0) {
        // Comment deleted successfully
        echo "Comment deleted successfully.";
        header("Location: profile.php");
    } else {
        // Comment not found or couldn't be deleted
        echo "Unable to delete comment.";
    }
} else {
    // Handle the case when comment_id is not provided
    echo "Invalid request. Comment ID not provided.";
}
?>
