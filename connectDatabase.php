<?php
$servername = "localhost";
$username = "guest";
$password = "ggcITEC4450@";
$dbname = "moviedb";
					
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>