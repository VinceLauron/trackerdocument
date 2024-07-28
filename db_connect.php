<?php

$conn = new mysqli('mysql.hostinger.com', 'u510162695_fms_db_root', '1Fms_db_root', 'u510162695_fms_db');

if ($conn->connect_error) {
    die("Could not connect to mysql: " . $conn->connect_error);
}

?>
