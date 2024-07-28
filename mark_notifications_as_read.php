<?php
session_start();

if (!isset($_SESSION['login_id'])) {
    header('location: login.php');
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fms_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE notifications SET status = 1";
$conn->query($sql);

$conn->close();
?>
