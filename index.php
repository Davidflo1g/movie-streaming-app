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
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('images/cinema-bg.jpg');
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
        .movie-poster {
            width: 100%;
            height: 400px;
            object-fit: contain;
            background-color: #000;
        }
        .movie-card {
            height: 600px;
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
                <!-- Titanic -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/titanic.jpg" class="movie-poster" alt="Titanic">
                        <div class="w3-container">
                            <h4>Titanic</h4>
                            <p>1997</p>
                            <p>Drama, Romance</p>
                            <p class="actor-list"><strong>Starring:</strong> Leonardo DiCaprio, Kate Winslet</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(1)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Casino Royale -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/casino-royale.jpg" class="movie-poster" alt="Casino Royale">
                        <div class="w3-container">
                            <h4>Casino Royale</h4>
                            <p>2006</p>
                            <p>Action, Adventure</p>
                            <p class="actor-list"><strong>Starring:</strong> Daniel Craig, Eva Green</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(2)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avatar -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/avatar.jpg" class="movie-poster" alt="Avatar">
                        <div class="w3-container">
                            <h4>Avatar</h4>
                            <p>2009</p>
                            <p>Action, Adventure, Sci-Fi</p>
                            <p class="actor-list"><strong>Starring:</strong> Sam Worthington, Zoe Saldana</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(3)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Dark Knight -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/dark-knight.jpg" class="movie-poster" alt="The Dark Knight">
                        <div class="w3-container">
                            <h4>The Dark Knight</h4>
                            <p>2008</p>
                            <p>Action, Crime, Drama</p>
                            <p class="actor-list"><strong>Starring:</strong> Christian Bale, Heath Ledger</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(4)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Notebook -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/notebook.jpg" class="movie-poster" alt="The Notebook">
                        <div class="w3-container">
                            <h4>The Notebook</h4>
                            <p>2004</p>
                            <p>Drama, Romance</p>
                            <p class="actor-list"><strong>Starring:</strong> Ryan Gosling, Rachel McAdams</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(5)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inception -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/inception.jpg" class="movie-poster" alt="Inception">
                        <div class="w3-container">
                            <h4>Inception</h4>
                            <p>2010</p>
                            <p>Action, Sci-Fi, Thriller</p>
                            <p class="actor-list"><strong>Starring:</strong> Leonardo DiCaprio, Ellen Page, Tom Hardy</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(6)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Shawshank Redemption -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/shawshank.jpg" class="movie-poster" alt="The Shawshank Redemption">
                        <div class="w3-container">
                            <h4>The Shawshank Redemption</h4>
                            <p>1994</p>
                            <p>Drama</p>
                            <p class="actor-list"><strong>Starring:</strong> Tim Robbins, Morgan Freeman</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(7)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pulp Fiction -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/pulp-fiction.jpg" class="movie-poster" alt="Pulp Fiction">
                        <div class="w3-container">
                            <h4>Pulp Fiction</h4>
                            <p>1994</p>
                            <p>Crime, Drama</p>
                            <p class="actor-list"><strong>Starring:</strong> John Travolta, Uma Thurman</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(8)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forrest Gump -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/forrest-gump.jpg" class="movie-poster" alt="Forrest Gump">
                        <div class="w3-container">
                            <h4>Forrest Gump</h4>
                            <p>1994</p>
                            <p>Drama, Romance</p>
                            <p class="actor-list"><strong>Starring:</strong> Tom Hanks, Robin Wright</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(9)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Matrix -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/matrix.jpg" class="movie-poster" alt="The Matrix">
                        <div class="w3-container">
                            <h4>The Matrix</h4>
                            <p>1999</p>
                            <p>Action, Sci-Fi</p>
                            <p class="actor-list"><strong>Starring:</strong> Keanu Reeves, Laurence Fishburne</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(10)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jurassic Park -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/jurassic-park.jpg" class="movie-poster" alt="Jurassic Park">
                        <div class="w3-container">
                            <h4>Jurassic Park</h4>
                            <p>1993</p>
                            <p>Adventure, Sci-Fi</p>
                            <p class="actor-list">Starring:</strong> Sam Neill, Laura Dern</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(11)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Goodfellas -->
                <div class="w3-col m3 w3-margin-bottom">
                    <div class="w3-card-4 w3-theme-d3 movie-card">
                        <img src="images/goodfellas.jpg" class="movie-poster" alt="Goodfellas">
                        <div class="w3-container">
                            <h4>Goodfellas</h4>
                            <p>1990</p>
                            <p>Biography, Crime, Drama</p>
                            <p class="actor-list"><strong>Starring:</strong> Robert De Niro, Ray Liotta</p>
                            <div class="w3-row">
                                <div class="w3-half">
                                    <button class="w3-button w3-cyan w3-block">Play</button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-green w3-block" onclick="addToWatchlist(12)">+ Watchlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
