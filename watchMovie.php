<?php
session_start();
require "connectDatabase.php";
require "utilFunctions.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Movie ID required
if (!isset($_GET['id'])) {
    die("No movie selected.");
}

$movie_id = intval($_GET['id']);

// Fetch movie info
$sql = "SELECT * FROM movies WHERE movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Movie not found.");
}

$movie = $result->fetch_assoc();

// YouTube ID from URL
$youtubeID = extractYouTubeID($movie['trailer_source']);

// Get user playback history
$history_sql = "
    SELECT progress_secs 
    FROM play_history 
    WHERE user_id = ? AND movie_id = ?
";
$stmt2 = $conn->prepare($history_sql);
$stmt2->bind_param("ii", $user_id, $movie_id);
$stmt2->execute();
$history_result = $stmt2->get_result();

$resumeTime = 0;
if ($history_result->num_rows > 0) {
    $resumeTime = intval($history_result->fetch_assoc()['progress_secs']);
}

// Prevent resuming at end
if ($resumeTime > $movie['secs'] - 5) {
    $resumeTime = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htc($movie['title']) . " (" . $movie['release_year'] . ")"; ?> - Watch Trailer</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        #playerContainer {
            max-width: 900px;
            margin: auto;
            margin-top: 40px;
        }

        .resume-box {
            margin: 20px auto;
            max-width: 900px;
            background: #222;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include "mainMenu.php"; ?>
    <div class="w3-container w3-center">
        <h2><?php echo htc($movie['title']) . " (" . $movie['release_year'] . ")"; ?></h2>
    </div>
    <?php if ($resumeTime > 5): ?>
        <div class="resume-box w3-center">
            <p>You last watched until <b><?php echo gmdate("i:s", $resumeTime); ?></b>.</p>
            <button class="w3-button w3-cyan" id="resumeBtn">Resume</button>
            <button class="w3-button w3-gray" id="restartBtn">Restart</button>
        </div>
    <?php endif; ?>
    <div id="playerContainer">
        <div id="player"></div>
    </div>
    <script>
        let player;
        let resumeTime = <?php echo $resumeTime; ?>;
        let movieID = <?php echo $movie_id; ?>;
        let userID = <?php echo $user_id; ?>;

        // Load YouTube API
        let tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        document.head.appendChild(tag);

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '500',
                width: '900',
                videoId: '<?php echo $youtubeID; ?>',
                playerVars: { controls: 1, autoplay: 0 },
                events: { 'onReady': onPlayerReady, 'onStateChange': onStateChange }
            });
        }

        function onPlayerReady() {
            document.getElementById("resumeBtn")?.addEventListener("click", () => {
                player.seekTo(resumeTime, true);
                player.playVideo();
            });

            document.getElementById("restartBtn")?.addEventListener("click", () => {
                player.seekTo(0, true);
                player.playVideo();
            });
        }

        function onStateChange(event) {
            if (event.data === YT.PlayerState.PLAYING) {
                setInterval(saveProgress, 3000);
            }
        }

        function saveProgress() {
            if (!player || player.getCurrentTime === undefined) return;
            let current = Math.floor(player.getCurrentTime());
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "updateProgress.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("movie_id=" + movieID +
                "&user_id=" + userID +
                "&progress_secs=" + current);
        }
    </script>

</body>

</html>