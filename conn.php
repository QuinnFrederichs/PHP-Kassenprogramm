<?php

// Server connection info
$servername = "SERVERNAME";
$username = "USERNAME";
$password = "PASSWORD";
$database= "abda_aek";

// Create connection
$conn =  mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



?>