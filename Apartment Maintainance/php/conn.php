<?php 
    $host="localhost";
    $user="root";
    $pass="rootmysql@1#";
    $db="apartment_maintainance";

    $conn = mysqli_connect($host, $user, $pass, $db);

    if (!$conn) {
        die("Error connecting to database");
    }
?>