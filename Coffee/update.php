<?php
require('connection.php');
require('authentication.php');
require('/Applications/XAMPP/xamppfiles/htdocs/wd2/Project(Github)/Coffee/php-image-resize-master/lib/ImageResize.php');
require('/Applications/XAMPP/xamppfiles/htdocs/wd2/Project(Github)/Coffee/php-image-resize-master/lib/ImageResizeException.php');

// Function to validate coffee shop details
function isValidCoffeeShop($name, $description) {
    return strlen($name) >= 1 && strlen($description) >= 1;
}

// Delete coffee shop
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_shop"])) {
    // Sanitize and get the coffee shop ID
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "DELETE FROM cafe WHERE Shop_id = :Shop_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);

    // Execute the DELETE.
    $statement->execute();

    // Redirect after deletion.
    header("Location: index.php");
    exit;
}

// UPDATE coffee shop if Name, Description, and id are present in POST.
if ($_POST && isset($_POST['Name']) && isset($_POST['Description']) && isset($_POST['Category']) && isset($_POST['id'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $name  = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = isset($_POST['Category']) && $_POST['Category'] !== '' ? filter_input(INPUT_POST, 'Category', FILTER_SANITIZE_NUMBER_INT) : null;
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Validate coffee shop details
    if (isValidCoffeeShop($name, $description)) {
        // Check if an image file was uploaded
        if (!empty($_FILES['image']['name'])) {
            $image_filename = $_FILES['image']['name']; // Get the image filename
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $new_image_path = 'uploads/' . $image_filename; // Destination path for the image

            // Move the uploaded image to the destination directory
            if (move_uploaded_file($temporary_image_path, $new_image_path)) {
                // Update the 'Image' column in the database with the new image filename
                $query = "UPDATE cafe SET Image = :Image WHERE Shop_id = :Shop_id";
                $statement = $db->prepare($query);
                $statement->bindValue(':Image', $image_filename);
                $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);
                $statement->execute();

                // Resize and crop the image
                $image = new \Gumlet\ImageResize($new_image_path);
                $image->crop(500, 500); // Crop the image to 250x250 pixels
                $image->save($new_image_path);
            } else {
                echo "Failed to upload image. Please try again.";
            }
        }

        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE cafe SET Name = :Name, Description = :Description, category_id = :category_id WHERE Shop_id = :Shop_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':Name', $name);
        $statement->bindValue(':Description', $description);
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);

        // Execute the UPDATE.
        $statement->execute();

        // Redirect after update.
        header("Location: profile.php?id={$id}");
        exit;
    } else {
        echo "Invalid coffee shop details. Please make sure all fields are filled out.";
    }
} elseif (isset($_GET['id'])) { // Retrieve coffee shop to be edited if id GET parameter is in URL.
    // Sanitize the id.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM cafe WHERE Shop_id = :Shop_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Shop_id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $shop = $statement->fetch();

    // Fetch categories from the database
    $queryCategories = "SELECT * FROM category";
    $categoriesStatement = $db->query($queryCategories);
    $categories = $categoriesStatement->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Set $id to a default value or handle the case where it's not set
    $id = ''; // Default value, you can change this as needed
    // Redirect to an appropriate page or handle the error
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pretty.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <title>Edit Coffee Shop</title>
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
        <form class="coffeeShopForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $shop['Shop_id'] ?>"><br>
            
            <label for="Name">Name</label>
            <input type="text" id="Name" name="Name" value="<?= $shop['Name'] ?>"><br>
            
            <label for="Description">Description</label>
            <textarea id="Description" name="Description" rows="5"><?= $shop['Description'] ?></textarea><br>


            <label for="Categories">Category</label>
            <select id="Categories" name="Category">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['type_id'] ?>">
                        <?= $category['type'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image"><br>

            <?php if (!empty($shop['Image'])): ?>
                <input type="checkbox" id="removeImage" name="removeImage">
                <label for="removeImage">Remove Image</label><br>
            <?php endif; ?>
            
            <button type="submit" value="Update">Update</button>
            <button type="submit" name="delete_shop" value="Delete" onclick="return confirm('Are you sure you want to delete this coffee shop?');">Delete</button>
        </form>
    <?php endif ?>
    </div>
        <!-- Summernote Initialization Script -->
        <script>
        $(document).ready(function() {
            $('#Description').summernote({
                placeholder: 'Enter description here...',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        $('#summernote').summernote();
    </script>
</body>
</html>
