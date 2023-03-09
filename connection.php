<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db="mnnit";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);
    // Check connection
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }else{
        echo "Connection is established.";
    }
?>