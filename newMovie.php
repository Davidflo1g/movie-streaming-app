<?php
include "utilFunctions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Movie</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="w3-container w3-black">
        <?php include "movieAdminMainMenu.php"; ?>
        <header class="w3-display-container w3-center">
            <h1><b>MovieFlix</b></h1>
            <h2>Add New Movie</h2>
        </header>
        <form method="POST" class="w3-container w3-light-grey">
            <fieldset>
                <legend class="w3-large w3-center w3-text-theme"><b>Movie Details</b></legend>

                <label>Title</label>
                <input type="text" name="title" class="w3-input w3-border" required>

                <label>Genre</label>
                <select name="genre_id" class="w3-select w3-border" required>
                    <option value="" disabled selected>Choose a Genre</option>
                    <?php
                    include "connectDatabase.php";

                    $genres = $conn->query("SELECT genre_id, genre_name FROM genres ORDER BY genre_id ASC");
                    while ($g = $genres->fetch_assoc()) {
                        echo "<option value='{$g['genre_id']}'>{$g['genre_id']} | {$g['genre_name']}</option>";
                    }
                    $conn->close();
                    ?>
                </select>

                <label>Release Year</label>
                <input type="text" name="release_year" class="w3-input w3-border" required>

                <label>Duration (in seconds)</label>
                <input type="text" name="secs" class="w3-input w3-border" required>

                <label>Director</label>
                <input type="text" name="director" class="w3-input w3-border" required>

                <label>Description</label>
                <textarea name="description" class="w3-input w3-border" required></textarea>

                <label>YouTube Trailer URL</label>
                <input type="text" name="trailer_source" class="w3-input w3-border" required>
            </fieldset>
            <br><input type="submit" name="submit" class="w3-btn w3-black" value="Add New Movie">
        </form>
        <div class="w3-container w3-light-grey">
            <?php
            if (isset($_POST['submit'])) {
                if (!isset($_POST['title']) || !isset($_POST['genre_id']) || !isset($_POST['release_year']) || !isset($_POST['secs']) || !isset($_POST['director']) || !isset($_POST['description']) || !isset($_POST['trailer_source'])) {
                    echo "You have not entered all the required information. Please go back and try again.";
                    exit;
                }

                include "connectDatabase.php";

                # create short variable names
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $genre_id = (int) $_POST['genre_id'];
                $release_year = (int) $_POST['release_year'];
                $secs = (int) $_POST['secs'];
                $director = mysqli_real_escape_string($conn, $_POST['director']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $trailer_source = mysqli_real_escape_string($conn, $_POST['trailer_source']);

                // Find the lowest missing ID
                $missingQuery = "
                    SELECT COALESCE(
                        (SELECT MIN(t1.movie_id + 1)
                        FROM movies t1
                        LEFT JOIN movies t2 ON t1.movie_id + 1 = t2.movie_id
                        WHERE t2.movie_id IS NULL),
                        1
                    ) AS nextID;
                ";
                $missingResult = $conn->query($missingQuery);
                $missingRow = $missingResult->fetch_assoc();
                $nextID = (int) $missingRow['nextID'];

                // Force use of missing ID or 1 if table empty
                $sql = "INSERT INTO movies 
                        (movie_id, title, genre_id, release_year, secs, director, description, trailer_source)
                        VALUES ($nextID, '$title', '$genre_id', '$release_year', '$secs', '$director', '$description', '$trailer_source')";

                if ($conn->query($sql) === TRUE) {
                    // Reset AUTO_INCREMENT to next available after MAX(movie_id)
                    $autoRes = $conn->query("SELECT IFNULL(MAX(movie_id), 0) + 1 AS nextAuto FROM movies");
                    $autoRow = $autoRes->fetch_assoc();
                    $nextAuto = (int) $autoRow['nextAuto'];
                    $conn->query("ALTER TABLE movies AUTO_INCREMENT = $nextAuto");

                    // Get genre name for display
                    $genreQuery = $conn->query("SELECT genre_name FROM genres WHERE genre_id = $genre_id");
                    $genreRow = $genreQuery->fetch_assoc();
                    $genreName = $genreRow ? $genreRow['genre_name'] : 'Unknown';

                    echo "<div class='w3-panel w3-green w3-round-large'>";
                    echo "<b>Movie added successfully!</b><br>";
                    echo "Movie ID: " . ($nextID == 'AUTO' ? $conn->insert_id : $nextID) . "<br>";
                    echo "Title: $title<br>";
                    echo "Genre ID: $genre_id ($genreName)<br>";
                    echo "Release Year: $release_year<br>";
                    echo "Duration: $secs<br>";
                    echo "Director: $director<br>";
                    echo "Description: $description<br>";
                    echo "Trailer URL: $trailer_source<br>";
                    echo "</div>";
                } else {
                    echo "<div class='w3-panel w3-red w3-round-large'>";
                    echo "<b>Error:</b> " . $conn->error;
                    echo "</div>";
                }
                $conn->close();
            }
            ?>
        </div>
    </div>
</body>

</html>