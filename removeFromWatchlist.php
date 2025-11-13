<?php
include "utilFunctions.php";
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

if(isset($_GET['movie_id'])) {
    $user_id = $_SESSION["user_id"];
    $movie_id = $_GET['movie_id'];
    
    include "connectDatabase.php";
    
    $sql = "DELETE FROM watchlists WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Movie removed from watchlist!'); window.location.href='watchlist.php';</script>";
    } else {
        echo "<script>alert('Error removing movie: " . $conn->error . "'); window.location.href='watchlist.php';</script>";
    }
    
    $conn->close();
} else {
    header("Location: watchlist.php");
}
?>