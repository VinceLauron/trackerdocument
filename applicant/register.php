<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $sex = $_POST['sex'];
    $program_graduated = $_POST['program_graduated'];
    $id_number = $_POST['id_number'];
    $year_graduated = $_POST['year_graduated'];
    $admission = $_POST['admission'];


    // Generate a verification code
    $verification_code = rand(100000, 999999);

    // Database connection
    $conn = new mysqli("localhost", "root", "", "fms_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO applicant (fullname, dob, email, contact, sex, program_graduated, id_number, year_graduated, admission, verification_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $fullname, $dob, $email, $contact, $sex, $program_graduated, $id_number, $year_graduated, $admission, $verification_code);

    if ($stmt->execute()) {
        // Send the verification code to the user's email
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'lauronvince13@gmail.com'; // SMTP username
            $mail->Password = 'vohwbqmjcwqifszs'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('lauronvince13@gmail.com', 'Mailer');
            $mail->addAddress($email, $fullname);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body    = 'Your verification code is: ' . $verification_code;
            $mail->AltBody = 'Your verification code is: ' . $verification_code;

            $mail->send();
            $_SESSION['email'] = $email;
            header("Location: verify.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to store user data.";
    }

    $stmt->close();
    $conn->close();
}
?>
