<?php
session_start();
require('connection.php');
?>

<header>
    <div class="logo">
        <a href="index.php">
            <img src="images/logo.jpg" alt="Description of the image" style="width: 150px; height: auto;">
        </a>
    </div>
    <div class="search">
        <form action="search.php" method="GET">
            <input type="text" id="search" name="search" placeholder="Enter keyword...">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="nav-container">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                // Check if user is logged in
                if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                    // User is logged in, display Profile and Log Out links
                    echo '<li><a href="profile.php">Profile</a></li>';
                    echo '<li><a href="logout.php" id="logoutLink">Log Out</a></li>';
                } else {
                    // User is not logged in, display Sign In link
                    echo '<li><a href="login.php">Sign In</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>
