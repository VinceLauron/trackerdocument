<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
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

$email = $_SESSION['email'];

// Fetch user's requests from the database
$stmt = $conn->prepare("SELECT id, id_number, fullname, contact, course, docu_type, purpose, status, note FROM request WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id, $id_number, $fullname, $contact, $course, $docu_type, $purpose, $status, $note);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Requests - MCC Document Tracker</title>
    <style>
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background: silver;
            color: black;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: #fff;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-view {
            background-color: #007bff;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
        @media (max-width: 768px) {
            .container {
                width: 100%;
                padding: 10px;
            }
            table, th, td {
                font-size: 14px;
                padding: 8px;
            }
            .btn {
                padding: 6px 12px;
                font-size: 14px;
            }
        }
        @media (max-width: 480px) {
            .container {
                padding: 5px;
            }
            table, th, td {
                font-size: 12px;
                padding: 6px;
            }
            .btn {
                padding: 4px 8px;
                font-size: 12px;
            }
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            table thead {
                display: none;
            }
            table tr {
                display: block;
                margin-bottom: 10px;
            }
            table td {
                display: block;
                text-align: right;
                border-bottom: 1px solid #ddd;
                position: relative;
                padding-left: 50%;
            }
            table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: calc(50% - 20px);
                padding-right: 10px;
                text-align: left;
                font-weight: bold;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Course/Program</th>
                    <th>Document Type</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($stmt->fetch()) {
                    $status_class = '';
                    if ($status == 'pending') {
                        $status_class = 'status-pending';
                    } elseif ($status == 'onprocess') {
                        $status_class = 'status-onprocess';
                    } elseif ($status == 'rejected') {
                        $status_class = 'status-rejected';
                    } elseif ($status == 'released') {
                        $status_class = 'status-released';
                    }
                    echo "<tr>";
                    echo "<td data-label='ID Number'>" . htmlspecialchars($id_number) . "</td>";
                    echo "<td data-label='Full Name'>" . htmlspecialchars($fullname) . "</td>";
                    echo "<td data-label='Contact'>" . htmlspecialchars($contact) . "</td>";
                    echo "<td data-label='Course/Program'>" . htmlspecialchars($course) . "</td>";
                    echo "<td data-label='Document Type'>" . htmlspecialchars($docu_type) . "</td>";
                    echo "<td data-label='Purpose'>" . htmlspecialchars($purpose) . "</td>";
                    echo "<td data-label='Status' class='$status_class'>" . htmlspecialchars($status) . "</td>";
                    echo "<td data-label='Note'>" . htmlspecialchars($note) . "</td>";
                    echo "<td data-label='Actions'>
                            <a href='view_request.php?id=" . htmlspecialchars($id) . "' class='btn btn-view'>View</a>
                            <a href='delete_request.php?id=" . htmlspecialchars($id) . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this request?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
