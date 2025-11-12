<?php
include "../connectDatabase.php";
include "../utilFunctions.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>MOVIE - Movie Reviews</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
<div class="w3-theme-d1">
    <?php include '../mainMenu.php'; ?>

    <div class="w3-container w3-padding-32">
        <h2>View Reviews by Movie</h2>

        <form class="w3-container w3-card w3-theme-d3" method="get" action="viewReview.php" style="max-width:600px; margin:auto;">
            <label><b>Select Movie</b></label>
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
            <p><button class="w3-button w3-cyan w3-round-large" type="submit">View Reviews</button></p>
        </form>

        <?php
        if (isset($_GET['movie_id'])) {
            $movie_id = mysqli_real_escape_string($conn, $_GET['movie_id']);
            $sql = "SELECT r.user_name, r.rating, r.comment, r.review_date, m.title 
                    FROM reviews r JOIN movies m ON r.movie_id = m.movie_id
                    WHERE r.movie_id = '$movie_id'
                    ORDER BY r.review_date DESC";
            $result = $conn->query($sql);

            echo "<div class='w3-container w3-padding-16'>";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h3>Reviews for: ".$row['title']."</h3><hr>";
                do {
                    echo "<div class='w3-card w3-margin w3-padding w3-theme-d3'>";
                    echo "<b>".$row['user_name']."</b> - Rating: ".$row['rating']."/5<br>";
                    echo "<p>".$row['comment']."</p>";
                    echo "<small>".$row['review_date']."</small>";
                    echo "</div>";
                } while ($row = $result->fetch_assoc());
            } else {
                echo "<p>No reviews yet for this movie.</p>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
</html>
