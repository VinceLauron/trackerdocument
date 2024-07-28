<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['verification_code'];
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    if (empty($email)) {
        echo "Session email not set. Please go back and register again.";
        exit;
    }

    // Database connection
    $conn = new mysqli("localhost", "root", "", "fms_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check the verification code
    $stmt = $conn->prepare("SELECT verification_code FROM applicant WHERE email = ? AND is_verified = 0");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($verification_code);
    $stmt->fetch();
    $stmt->close();

    if ($entered_code == $verification_code) {
        // Update user to set is_verified to true
        $stmt = $conn->prepare("UPDATE applicant SET is_verified = 1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();

        echo "Verification successful. You can now log in using the verification code as your password.";
    } else {
        echo "Invalid verification code.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
<link href="styles.css">
    <title>Verify Email</title>
</head>
<body>
    <div class="container">
        

        <form action="verify.php" method="POST">
        <header>Email Verification</header>
            <div class="form">
                <div class="details verification">
                    <span class="title">Enter Verification Code</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Verification Code</label>
                            <input type="text" name="verification_code" placeholder="Enter the code sent to your email" required>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="submit">
                            <span class="btnText">Verify</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                       <a href="login.php"> <button type="button" class="primary">Login Applicant</button> </a><!-- Added primary class -->
                    </div> 
                </div>
            </div>
        </form>
    </div>
</body>
</html>
