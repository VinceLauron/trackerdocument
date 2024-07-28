<?php
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>MCC DOCUMENT TRACKER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        #sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
            background-color: #2a2f5b;
            padding-top: 20px;
            left: 0;
            transition: transform 0.3s ease-in-out;
        }

        #sidebar .sidebar-list {
            padding: 0;
            list-style: none;
        }

        #sidebar .nav-item {
            display: block;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        #sidebar .nav-item .icon-field {
            margin-right: 10px;
        }

        #sidebar .nav-item:hover,
        #sidebar .nav-item.active {
            background-color: #495057;
        }

        #sidebar .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: auto;
        }

        #sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            font-size: 24px;
            color: black;
            cursor: pointer;
            z-index: 1000;
        }

        #main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-250px);
            }

            #sidebar-toggle {
                display: block;
            }

            #main-content {
                margin-left: 0;
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content.shifted {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <div id="sidebar-toggle"><i class="fas fa-bars"></i></div>
    <nav id="sidebar" class="mx-lt-5 bg-dark">
        <img src="assets/img/mcc1.png" class="logo">
        <div class="sidebar-list">
            <div class="nav-item nav-home" onclick="loadContent('home.php')">
                <span class="icon-field"><i class="fa fa-home"></i></span> Home
            </div>
            <div class="nav-item nav-files" onclick="loadContent('request_form.php')">
                <span class="icon-field"><i class="fa fa-envelope"></i></span> Request Form
            </div>
            <div class="nav-item nav-files" onclick="loadContent('receive_form.php')">
                <span class="icon-field"><i class="fa fa-envelope-open"></i></span> Status Request
            </div>
            <div class="nav-item nav-users" onclick="loadContent('user_details.php')">
                <span class="icon-field"><i class="fa fa-users"></i></span> User Details
            </div>
        </div>
    </nav>

    <div id="main-content">
        <!-- Main content goes here -->
    </div>

    <script>
        function loadContent(page) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('main-content').innerHTML = this.responseText;
                }
            };
            xhr.send();
        }

        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('shifted');
        });
    </script>
</body>
</html>
