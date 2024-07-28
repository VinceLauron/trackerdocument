<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['login_id']))
header('location:login.php');
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $request_id = $_GET['id'];

    // Delete the request from the database
    $stmt = $conn->prepare("DELETE FROM request WHERE id = ?");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the requests page after deletion
    header("Location: index.php");
    exit();
} else {
    echo "Invalid request ID.";
    exit();
}

$conn->close();
?>
