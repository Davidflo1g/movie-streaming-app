<?php
include "../connectDatabase.php";
include "../utilFunctions.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>MOVIE - Add Review</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
<div class="w3-theme-d1">
    <?php include '../mainMenu.php'; ?>

    <div class="w3-container w3-padding-32">
        <h2>Add a Review</h2>

        <form class="w3-container w3-card w3-theme-d3" action="addReview.php" method="post" style="max-width:600px; margin:auto;">
            <label><b>Movie</b></label>
            <select class="w3-select" name="movie_id" required>
                <option value="" disabled selected>Select a Movie</option>
                <?php
                $sql = "SELECT movie_id, title FROM movies ORDER BY title";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['movie_id']."'>".$row['title']."</option>";
                }
                ?>
            </select><br>

            <label><b>Rating (1-5)</b></label>
            <input class="w3-input w3-border" type="number" name="rating" min="1" max="5" required><br>

            <label><b>Comment</b></label>
            <textarea class="w3-input w3-border" name="comment" rows="4" required></textarea><br>

            <p><button class="w3-button w3-cyan w3-round-large" type="submit" name="submit">Submit Review</button></p>
        </form>
    </div>

    <div class="w3-container w3-padding">
        <?php
        if (isset($_POST['submit'])) {
            // Assume user is logged in
            $user_name = "testuser"; // to be replaced with session variable later
            $movie_id = mysqli_real_escape_string($conn, $_POST['movie_id']);
            $rating = mysqli_real_escape_string($conn, $_POST['rating']);
            $comment = mysqli_real_escape_string($conn, $_POST['comment']);

            $sql = "INSERT INTO reviews (movie_id, user_name, rating, comment, review_date)
                    VALUES ('$movie_id', '$user_name', '$rating', '$comment', NOW())";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='w3-panel w3-green w3-padding'>Review added successfully!</div>";
            } else {
                echo "<div class='w3-panel w3-red w3-padding'>Error: " . $conn->error . "</div>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
