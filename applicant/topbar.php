<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">
    <style>
         .topbar {
            position: fixed;
            width: 100%;
            height: 60px;
            background-color: #2a2f5b;
            color: white;
            display: flex;
            justify-content: space-between; /* Align items on both ends */
            align-items: center;
            padding: 0 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Make sure it is above other content */
            top: 0; /* Ensure it is placed at the top */
        }
        .topbar-menu {
            display: flex;
            align-items: center;
        }
        .topbar-menu a {
            color: white;
            text-decoration: none;
            margin-left: 20px; /* Adjust spacing */
            display: flex;
            align-items: center;
        }
        .topbar-menu a .fa {
            margin-right: 5px;
        }
        .topbar-brand {
            font-size: 24px;
            font-weight: bold;
        }
        .topbar-brand, .topbar-menu {
            flex: 1; /* Distribute space between brand and menu */
        }
        .nav-links li {
            list-style: none;
            margin: 0 12px;
        }
        .nav-links li a {
            position: relative;
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            padding: 6px 0;
            text-decoration: none;
            margin-left: 30px;
            padding: 60px;
            display: flex;
            align-items: center;
        }

        .topbar .topbar-menu .fa {
            margin-right: 5px; /* Space between icon and text */
        }

        #sidebar {
            position: fixed;
            top: 60px; /* Make sure the sidebar starts below the topbar */
            width: 250px;
            height: calc(100% - 60px);
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
            z-index: 1100;
        }

        #main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            padding-top: 80px; /* Ensure content is not hidden under the topbar */
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
    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script>
        function confirmLogout(event) {
            event.preventDefault(); // Prevent the default action
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to logout.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with logout
                    window.location.href = event.target.href;
                }
            });
        }
    </script>
</head>
<body>
    <div class="topbar">
        <div class="topbar-brand">MCC Document Tracker</div>
        <div class="topbar-menu" style="justify-content: flex-end; margin-right: 55px;">
            <a href="login.php" class="logout" onclick="confirmLogout(event)">
                <i class="fa fa-power-off"></i> Logout<br>
                <?php echo $_SESSION['fullname']; ?>
            </a>
        </div>
    </div>
</body>
</html>
