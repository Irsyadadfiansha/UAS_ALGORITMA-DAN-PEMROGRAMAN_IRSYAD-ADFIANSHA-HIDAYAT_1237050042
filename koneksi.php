<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $my_db = "toko_online";

        // Create connection
        $con = mysqli_connect($servername, $username, $password,$my_db);

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
        }
        //echo "Connected successfully";
        
?>