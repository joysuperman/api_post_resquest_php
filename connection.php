<?php

    // Database configuration
    $servername = "localhost";
    $username = 'admin';
    $password = 'admin';
    $dbname = "product_review";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn,'utf8');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>
