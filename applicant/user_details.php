<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "fms_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email']; // Assuming the email is stored in session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted form data
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $sex = $_POST['sex'];
    $program_graduated = $_POST['program_graduated'];
    $id_number = $_POST['id_number'];
    $year_graduated = $_POST['year_graduated'];
    $admission = $_POST['admission'];

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE applicant SET fullname=?, dob=?, contact=?, sex=?, program_graduated=?, id_number=?, year_graduated=?, admission=? WHERE email=?");
    $stmt->bind_param("sssssssss", $fullname, $dob, $contact, $sex, $program_graduated, $id_number, $year_graduated, $admission, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['fullname'] = $fullname; // Update session variable with new fullname if needed
        // Success message using SweetAlert
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success!",
                        text: "Details updated successfully",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "index.php"; // Redirect to dashboard or another page
                    });
                });
              </script>';
    } else {
        // Error message using SweetAlert
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to update details",
                        icon: "error",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location.href = "index.php"; // Redirect to dashboard or another page
                    });
                });
              </script>';
    }

    $stmt->close();
}

// Retrieve user details
$stmt = $conn->prepare("SELECT fullname, dob, email, contact, sex, program_graduated, id_number, year_graduated, admission FROM applicant WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($fullname, $dob, $email, $contact, $sex, $program_graduated, $id_number, $year_graduated, $admission);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <style>
        .container {
            background-color: #fff;
            padding: 2em;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        .form-group {
            margin-bottom: 1em;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5em;
        }
        .form-group input {
            width: 100%;
            padding: 0.5em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            padding: 0.75em 1.5em;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h1>User Details</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
                <label for="id_number">ID Number:</label>
                <input type="text" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" required>
            </div>
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="contact">Mobile Number:</label>
                <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
            </div>
            <div class="form-group">
                <label for="sex">Gender:</label>
                <input type="text" id="sex" name="sex" value="<?php echo htmlspecialchars($sex); ?>" required>
            </div>
            <div class="form-group">
                <label for="program_graduated">Program Graduated:</label>
                <input type="text" id="program_graduated" name="program_graduated" value="<?php echo htmlspecialchars($program_graduated); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="year_graduated">Year Graduated:</label>
                <input type="text" id="year_graduated" name="year_graduated" value="<?php echo htmlspecialchars($year_graduated); ?>" required>
            </div>
            <div class="form-group">
                <label for="admission">Year Of Admission:</label>
                <input type="text" id="admission" name="admission" value="<?php echo htmlspecialchars($admission); ?>" required>
            </div>

            <div class="form-group">
                <button type="submit">Update Details</button>
            </div>
        </form>
    </div>
</body>
</html>
