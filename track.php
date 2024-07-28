<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />
    <title>MCC FILE AND DOCUMENT TRACKER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin: 20px auto;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], button {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mqj8eWYk6/eqZJLxKD2I+8t5tAVa3EaKw0C65sXJ4DLw0i2xMv2QYCyW4z5y3uTzVlGzmHScHrjnqNoA4OwCtg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<h1>Track Files</h1>
<form method="post">
    <label>Search</label>
    <input type="text" name="search" placeholder="Enter Tracking Number...">
    <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
</form>

<?php
  if(!isset($_SESSION['login_id']))
  header('location:login.php');
// Check if form is submitted
if (isset($_POST["submit"])) {
    // Establish database connection
    $conn = new mysqli('localhost', 'root', '', 'fms_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and get search term
    $file_number = $_POST["search"];
    
    // Prepare SQL statement with parameter placeholder
    $stmt = $conn->prepare("SELECT * FROM files WHERE file_number = ?");
    
    // Bind parameter and execute query
    $stmt->bind_param("s", $file_number);
    $stmt->execute();
    
    // Get result
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        ?>
        <br><br><br>
        <table>
            <tr>
                <th>Id</th>
                <th>File Number</th>
                <th>File Name</th>
                <th>Full Name</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
            <?php
            // Output data of each row
            while ($row = $result->fetch_object()) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row->id); ?></td>
                    <td><?php echo htmlspecialchars($row->file_number); ?></td>
                    <td><?php echo htmlspecialchars($row->name); ?></td>
                    <td><?php echo htmlspecialchars($row->fullname); ?></td>
                    <td><?php echo htmlspecialchars($row->description); ?></td>
                    <td><?php echo htmlspecialchars($row->date_updated); ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo "File Number does not exist";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
