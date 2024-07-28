<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // In this case, the password is the verification code

    // Database connection
    $conn = new mysqli("localhost", "root", "", "fms_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email and verification code match
    $stmt = $conn->prepare("SELECT fullname FROM applicant WHERE email = ? AND verification_code = ? AND is_verified = 1");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['fullname'] = $user['fullname'];

        // Display SweetAlert
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success!",
                        text: "Login successful!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "index.php"; // Redirect to dashboard or another page
                    });
                });
              </script>';
    } else {
        // Display SweetAlert for invalid login
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid email or verification code.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
              </script>';
    }

    $stmt->close();
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
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 2em;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        header {
            font-size: 24px;
            margin-bottom: 1em;
            color: #333;
        }
        .form {
            width: 100%;
        }
        .details {
            margin-bottom: 1em;
        }
        .title {
            font-size: 18px;
            margin-bottom: 0.5em;
            color: #555;
        }
        .fields {
            margin-bottom: 1em;
        }
        .input-field {
            margin-bottom: 1em;
        }
        .input-field label {
            display: block;
            margin-bottom: 0.5em;
            color: #555;
        }
        .input-field input {
            width: 100%;
            padding: 0.5em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
        .submit {
            background-color: #007BFF;
            color: #fff;
            padding: 0.75em 1.5em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 1em;
        }
        .submit:hover {
            background-color: #0056b3;
        }
        .signup-link {
            color: #007BFF;
            text-decoration: none;
        }
        .signup-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1> Applicant Sign In</h1>
    <header>Login</header>
    <form action="login.php" method="POST">
        <div class="form">
            <div class="details">
                <div class="input-field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="buttons">
                    <button type="submit" class="submit">
                        <span class="btnText">Login</span>
                    </button>
                    <a href="signup.php" class="signup-link">Don't have an account? Sign up here</a>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>
