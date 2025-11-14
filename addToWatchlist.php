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
    $date_added = date('Y-m-d');
    
    include "connectDatabase.php";
    
    // Check if already in watchlist
    $check_sql = "SELECT * FROM watchlists WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
    $check_result = $conn->query($check_sql);
    
    if($check_result->num_rows == 0) {
        $sql = "INSERT INTO watchlists (user_id, movie_id, date_added) VALUES ('$user_id', '$movie_id', '$date_added')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Movie added to watchlist!'); window.location.href='watchlist.php';</script>";
        } else {
            echo "<script>alert('Error adding to watchlist: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Movie is already in your watchlist!'); window.history.back();</script>";
    }
    
    $conn->close();
} else {
    header("Location: index.php");
}
?>