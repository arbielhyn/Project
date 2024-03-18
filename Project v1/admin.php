<?php
require('connection.php');

// Check if the form is submitted and required fields are not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['hours']) && !empty($_POST['website']) && !empty($_POST['description'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hours = filter_input(INPUT_POST, 'hours', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    // Build the parameterized SQL query to insert new coffee shop
    $query = "INSERT INTO coffee_shop (name, location, hours, website, description) VALUES (:name, :location, :hours, :website, :description)";
    $statement = $db->prepare($query);
    
    // Bind values to the parameters
    $statement->bindValue(':name', $name);
    $statement->bindValue(':location', $location);
    $statement->bindValue(':hours', $hours);
    $statement->bindValue(':website', $website);
    $statement->bindValue(':description', $description);
    
    // Execute the INSERT query
    if ($statement->execute()) {
        echo "New coffee shop added successfully!";
        // Redirect to a confirmation page or wherever you desire
        header("Location: index.php");
        exit;
    } else {
        echo "Failed to add new coffee shop.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Coffee Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('nav.php'); ?>
    <h1>Add New Coffee Shop</h1>
    <form action="admin.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location"><br>
        <label for="hours">Hours:</label>
        <input type="text" id="hours" name="hours"><br>
        <label for="website">Website:</label>
        <input type="text" id="website" name="website"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4"></textarea><br>
        <button type="submit">Add Coffee Shop</button>
    </form>
</body>
</html>
