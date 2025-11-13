<?php
session_start();

// Prevent caching - stops back button after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include "utilFunctions.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>MovieFlix - Movie Streaming</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('cinema-bg.jpg');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .search-box {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <div class="w3-theme-d1">
        <?php include 'mainMenu.php'; ?>
        
        <div class="hero-section">
            <div class="search-box">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
                <?php else: ?>
                    <h1>Welcome to MovieFlix</h1>
                <?php endif; ?>
                <p>Stream thousands of movies and TV shows</p>
                <input type="text" class="w3-input w3-border w3-round-large" placeholder="Search movies, actors, genres..." style="width: 400px; display: inline-block;">
                <button class="w3-button w3-cyan w3-round-large">Search</button>
            </div>
        </div>

        <div class="w3-container w3-padding-32">
            <h2>Featured Movies</h2>
            <div class="w3-row-padding">
                <!-- Featured movies will go here -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3">
                        <img src="movie1.jpg" style="width:100%">
                        <div class="w3-container">
                            <h4>Titanic</h4>
                            <p>1997</p>
                            <p>Drama, Romance</p>
                            <button class="w3-button w3-cyan w3-block">Play</button>
                        </div>
                    </div>
                </div>
                <!-- More movie cards... -->
            </div>
        </div>
    </div>
</body>
</html>