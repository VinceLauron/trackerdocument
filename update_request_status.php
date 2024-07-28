<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];
    $note = $_POST['note'];

    if ($action == 'onprocess') {
        $status = 'onprocess';
    } else if ($action == 'reject') {
        $status = 'rejected';
    } else if ($action == 'release') {
        $status = 'released';
    }

    // Update the request status and note
    $stmt = $conn->prepare("UPDATE request SET status = ?, note = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $note, $request_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Request status updated successfully.";
        
        // Close the statement
        $stmt->close();

        // Fetch the user's email
        $stmt = $conn->prepare("SELECT email FROM request WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        
        // Close the statement
        $stmt->close();

        // Send an email to the user with the note
        $subject = "Request Status Update";
        $message = "Your request has been " . $status . ".\n\nNote: " . $note;
        $headers = "From: no-reply@example.com";

        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['message'] .= " Notification email sent.";
        } else {
            $_SESSION['message'] .= " Error sending notification email.";
        }
    } else {
        $_SESSION['message'] = "Error updating request status: " . $stmt->error;
    }

    header("Location: indexs.php");
    exit();
}

$conn->close();
?>
