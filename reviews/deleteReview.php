<?php
include "../connectDatabase.php";
include "../utilFunctions.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>MOVIE - Delete Review</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
<div class="w3-theme-d1">
    <?php include '../mainMenu.php'; ?>

    <div class="w3-container w3-padding-32">
        <h2>Delete Review</h2>

        <form class="w3-container w3-card w3-theme-d3" action="deleteReview.php" method="post" style="max-width:600px; margin:auto;">
            <label><b>Select Review</b></label>
            <select class="w3-select" name="review_id" required>
                <option value="" disabled selected>Select a Review</option>
                <?php
                $sql = "SELECT review_id, comment FROM reviews ORDER BY review_date DESC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['review_id']."'>#".$row['review_id']." - ".substr($row['comment'], 0, 40)."...</option>";
                }
                ?>
            </select><br>

            <p><button class="w3-button w3-red w3-round-large" type="submit" name="submit">Delete Review</button></p>
        </form>

        <div class="w3-container w3-padding">
            <?php
            if (isset($_POST['submit'])) {
                $review_id = mysqli_real_escape_string($conn, $_POST['review_id']);
                $sql = "DELETE FROM reviews WHERE review_id='$review_id'";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='w3-panel w3-green w3-padding'>Review deleted successfully!</div>";
                } else {
                    echo "<div class='w3-panel w3-red w3-padding'>Error: " . $conn->error . "</div>";
                }
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
