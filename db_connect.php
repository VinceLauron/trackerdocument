<?php
$servername = '127.0.0.1'; // or your database server address
$username = 'u510162695_fms_db_root';
$password = '1Fms_db_root';
$dbname = 'u510162695_fms_db';
$port = 3306; // or your database port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
