<?php
// Include necessary functions for file upload and image validation
function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temporary_path, $new_path) {
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
    
    $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type = getimagesize($temporary_path)['mime'];
    
    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);
    
    return $file_extension_is_valid && $mime_type_is_valid;
}

require('connection.php');
require('authentication.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['Name']) && !empty($_POST['Description'])) {
        $name = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Check if an image file was uploaded
        if (!empty($_FILES['image']['name'])) {
            $image_filename = $_FILES['image']['name'];
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $new_image_path = file_upload_path($image_filename);
            
            // Validate the uploaded image
            if (file_is_an_image($temporary_image_path, $new_image_path)) {
                // Move the uploaded image to the uploads directory
                move_uploaded_file($temporary_image_path, $new_image_path);
            } else {
                // Image upload failed validation
                echo "Failed to upload image. Please ensure you are uploading a valid image file (JPEG, PNG, or GIF).";
            }
        }

        // Insert coffee shop data into the database
        $query = "INSERT INTO cafe (name, description, image) VALUES (:Name, :Description, :Image)";
        $statement = $db->prepare($query);
        $statement->bindValue(':Name', $name);
        $statement->bindValue(':Description', $description);
        $statement->bindValue(':Image', $image_filename ?? null); // Use null if no image was uploaded

        if ($statement->execute()) {
            echo "Success";
        } else {
            echo "Failed to add coffee shop";
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Coffee Shop</title>
    <link rel="stylesheet" href="pretty.css">
</head>
<body>
<?php include('nav.php'); ?>

<a href="profile.php" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </a>

<div class="container">
    <h1>Add New Coffee Shop</h1>
    <form class="coffeeShopForm" action="admin.php" method="POST">
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name"><br>

        <label for="Description">Description:</label><br>
        <textarea id="Description" name="Description" rows="4"></textarea><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image"><br>

        <button type="submit">Add Coffee Shop</button>
    </form>

</div>
</body>
</html>
