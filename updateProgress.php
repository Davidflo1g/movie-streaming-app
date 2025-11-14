<?php
require "connectDatabase.php";
require "utilFunctions.php";

$movie_id = intval($_POST['movie_id']);
$user_id = intval($_POST['user_id']);
$progress_secs = intval($_POST['progress_secs']);

saveProgress($conn, $user_id, $movie_id, $progress_secs);

echo "OK";
?>
