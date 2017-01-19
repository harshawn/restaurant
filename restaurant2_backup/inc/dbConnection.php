<?php
    $servername = "localhost";
    $user = "root";
    $password = "";
    $db = "restbook_system";
    // Create connection
    $conn = new mysqli($servername, $user, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Connection Failed";
    } 
   // echo "Connected successfully"
?>