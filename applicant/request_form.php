<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $fullname = htmlspecialchars($_POST['fullname']);
    $contact = htmlspecialchars($_POST['contact']);
    $id_number = htmlspecialchars($_POST['id_number']);
    $course = htmlspecialchars($_POST['course']);
    $docu_type = htmlspecialchars($_POST['docu_type']);
    $purpose = htmlspecialchars($_POST['purpose']);
    $date_created = htmlspecialchars($_POST['date_created']);
    $email = $_SESSION['email']; // Get the logged-in user's email

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

    // Insert data into database
    $sql = "INSERT INTO request (fullname, contact, id_number, course, docu_type, purpose, date_created, email, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $fullname, $contact, $id_number, $course, $docu_type, $purpose, $date_created, $email);

    if ($stmt->execute()) {
        // Insert notification into database
        $notification_message = "New request submitted by " . $fullname;
        $notif_sql = "INSERT INTO notifications (user_email, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_stmt->bind_param("ss", $email, $notification_message);
        $notif_stmt->execute();

        // Display SweetAlert message
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Success!",
                    text: "Request submitted successfully",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "index.php";
                });
            });
        </script>';
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error!",
                    text: "There was an error submitting your request",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        </script>';
    }

    // Close connection
    $stmt->close();
    $notif_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
  <title>Request Form - MCC Document Tracker</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .main-container {
      display: flex;
      justify-content: space-between;
      margin: 50px auto;
      max-width: 1200px;
    }

    .container, .table-container {
      background: #fff;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
    }

    .container {
      width: 60%;
    }

    .table-container {
      width: 50%;
      margin-left: 20px;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group textarea {
      resize: vertical;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background: #2a2f5b;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn:hover {
      background: #495057;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <div class="main-container">
    <div class="container">
      <h2>Request Form</h2>
      <form id="requestForm" action="request_form.php" method="POST">
        <div class="form-group">
          <label for="id_number">ID Number:</label>
          <input type="text" id="id_number" name="id_number" required>
        </div>
        <div class="form-group">
          <label for="fullname">Full Name:</label>
          <input type="text" id="fullname" name="fullname" required>
        </div>
        <div class="form-group">
          <label for="contact">Contact:</label>
          <input type="text" id="contact" name="contact" required>
        </div>
        <div class="form-group">
          <label for="course">Course:</label>
          <select id="course" name="course" required>
            <option value="" disabled selected>Select Course Here</option>
            <option value="BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY">BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY</option>
            <option value="BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT">BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT</option>
            <option value="BACHELOR OF SCIENCE IN HOSPITALITY MANAGMENT">BACHELOR OF SCIENCE IN HOSPITALITY MANAGMENT</option>
            <option value="BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO">BACHELOR OF SCIENCE IN SECONDARY EDUCATION MAJOR IN FILIPINO</option>
            <option value="BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION">BACHELOR OF SCIENCE IN ELEMENTARY EDUCATION</option>
          </select>
        </div>
        <div class="form-group">
          <label for="docu_type">Document Type:</label>
          <select id="docu_type" name="docu_type" required>
            <option value="" disabled selected>Select Document Type</option>
            <option value="GOOD MORAL CERTIFICATES">Good Moral Certificate</option>
            <option value="TRANSCRIPT OF RECORDS">TOR</option>
          </select>
        </div>
        <div class="form-group">
          <label for="purpose">Purpose of Request:</label>
          <textarea id="purpose" name="purpose" rows="4" required></textarea>
        </div>
        <div class="form-group">
          <label for="date_created">Date Of Request:</label>
          <input type="datetime-local" id="date_created" name="date_created" required>
        </div>
        <button type="submit" class="btn">Submit Request</button>
      </form>
    </div>
    <div class="table-container">
      <table>
        <h2 style="text-align: center;">NOTES FOR REQUESTING DOCUMENTS</h2>
        <tr>
          <th>DOCUMENTS</th>
          <th>FEES</th>
          <th>REQUIREMENTS</th>
          <th>SEVERAL DAYS OF PROCESS</th>
        </tr>
        <tr>
          <td>TOR</td>
          <td>150</td>
          <td>VALID ID</td>
          <td>7 DAYS</td>
        </tr>
        <tr>
          <td>GOOD MORAL</td>
          <td>FREE</td>
          <td>VALID ID</td>
          <td>7 DAYS</td>
        </tr>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
