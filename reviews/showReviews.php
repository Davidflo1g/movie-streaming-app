<?php
include "../connectDatabase.php";
include "../utilFunctions.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>MOVIE - All Reviews</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
<div class="w3-theme-d1">
    <?php include '../mainMenu.php'; ?>

    <div class="w3-container w3-padding-32">
        <h2>All Reviews</h2>

        <div class="w3-responsive">
        <?php
        $sql = "SELECT r.review_id, m.title AS movie_title, r.user_name, r.rating, r.comment, r.review_date 
                FROM reviews r 
                JOIN movies m ON r.movie_id = m.movie_id
                ORDER BY r.review_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='w3-table w3-striped w3-bordered w3-card'>";
            echo "<tr class='w3-cyan'>
                    <th>ID</th>
                    <th>Movie</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['review_id']."</td>";
                echo "<td>".$row['movie_title']."</td>";
                echo "<td>".$row['user_name']."</td>";
                echo "<td>".$row['rating']."</td>";
                echo "<td>".$row['comment']."</td>";
                echo "<td>".$row['review_date']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No reviews found.</p>";
        }
        ?>
        </div>
    </div>
</div>
</body>
</html>
