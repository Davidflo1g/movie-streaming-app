<?php
include "utilFunctions.php";
session_start();

// Check if user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Define genre mapping for each movie
$genre_mapping = [
    1 => 'Drama, Romance',
    2 => 'Action, Adventure', 
    3 => 'Action, Adventure, Sci-Fi',
    4 => 'Action, Crime, Drama',
    5 => 'Drama, Romance',
    6 => 'Action, Sci-Fi, Thriller',
    7 => 'Drama',
    8 => 'Crime, Drama',
    9 => 'Drama, Romance',
    10 => 'Action, Sci-Fi',
    11 => 'Adventure, Sci-Fi',
    12 => 'Biography, Crime, Drama'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>MovieFlix - My Watchlist</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .movie-poster {
            width: 100%;
            height: 400px;
            object-fit: contain;
            background-color: #000;
        }
        .movie-card {
            height: 650px;
            display: flex;
            flex-direction: column;
        }
        .movie-card .w3-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .movie-card .w3-container .w3-row {
            margin-top: auto;
        }
        .actor-list {
            font-size: 12px;
            color: #ccc;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="w3-theme-d1">
        <?php include 'mainMenu.php'; ?>
        
        <div class="w3-container w3-padding-32">
            <h1>My Watchlist</h1>
            
            <?php
            $user_id = $_SESSION["user_id"];
            include "connectDatabase.php";
            
            // Get user's watchlist with actor information
            $sql = "SELECT m.movie_id, m.title, m.release_year, g.genre_name, m.description, w.date_added,
                           GROUP_CONCAT(DISTINCT a.actor_name SEPARATOR ', ') as actors
                    FROM watchlists w 
                    JOIN movies m ON w.movie_id = m.movie_id 
                    JOIN genres g ON m.genre_id = g.genre_id 
                    LEFT JOIN movie_actors ma ON m.movie_id = ma.movie_id 
                    LEFT JOIN actors a ON ma.actor_id = a.actor_id 
                    WHERE w.user_id = '$user_id' 
                    GROUP BY m.movie_id
                    ORDER BY w.date_added DESC";
            
            $result = $conn->query($sql);
            
            if($result->num_rows > 0) {
                echo "<div class='w3-row-padding'>";
                
                while($row = $result->fetch_assoc()) {
                    // Create image filename from movie title
                    $image_file = 'images/' . strtolower(str_replace(' ', '-', $row['title'])) . '.jpg';
                    
                    // Get the correct genre from our mapping
                    $movie_genre = isset($genre_mapping[$row['movie_id']]) ? $genre_mapping[$row['movie_id']] : $row['genre_name'];
                    
                    echo "<div class='w3-col m3 w3-margin-bottom'>";
                    echo "  <div class='w3-card-4 w3-theme-d3 movie-card'>";
                    echo "    <img src='" . $image_file . "' class='movie-poster' alt='" . $row['title'] . "'>";
                    echo "    <div class='w3-container'>";
                    echo "      <h4>" . $row['title'] . " (" . $row['release_year'] . ")</h4>";
                    echo "      <p><strong>Genre:</strong> " . $movie_genre . "</p>";
                    echo "      <p class='actor-list'><strong>Starring:</strong> " . (isset($row['actors']) ? $row['actors'] : 'No actors listed') . "</p>";
                    echo "      <p class='w3-small'>" . (isset($row['description']) ? substr($row['description'], 0, 100) . "..." : "No description available") . "</p>";
                    echo "      <p class='w3-tiny'>Added: " . $row['date_added'] . "</p>";
                    echo "      <div class='w3-row'>";
                    echo "        <div class='w3-half'>";
                    echo "          <button class='w3-button w3-cyan w3-block' onclick='playMovie(" . $row['movie_id'] . ")'>Play</button>";
                    echo "        </div>";
                    echo "        <div class='w3-half'>";
                    echo "          <button class='w3-button w3-red w3-block' onclick='removeFromWatchlist(" . $row['movie_id'] . ")'>Remove</button>";
                    echo "        </div>";
                    echo "      </div>";
                    echo "    </div>";
                    echo "  </div>";
                    echo "</div>";
                }
                
                echo "</div>";
            } else {
                echo "<div class='w3-panel w3-theme-d3'>";
                echo "<p>Your watchlist is empty. Start adding movies to watch later!</p>";
                echo "<a href='index.php' class='w3-button w3-cyan'>Browse Movies</a>";
                echo "</div>";
            }
            
            $conn->close();
            ?>
        </div>
    </div>

    <script>
    function playMovie(movieId) {
        window.location.href = 'play.php?movie_id=' + movieId;
    }
    
    function removeFromWatchlist(movieId) {
        if(confirm('Remove this movie from your watchlist?')) {
            window.location.href = 'removeFromWatchlist.php?movie_id=' + movieId;
        }
    }
    </script>
</body>
</html>