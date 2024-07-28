<?php

$conn = new mysqli('127.0.0.1', 'u510162695_fms_db_root', '1Fms_db_root', 'u510162695_fms_db', 3306);

if ($conn->connect_error) {
    die("Could not connect to mysql: " . $conn->connect_error);
}

?>
