<?php
if (!isset($_SESSION['login_id'])) {
    header('location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />
    <title>MCC FILE AND DOCUMENT TRACKER</title>  

    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .logo {
            margin: auto;
            font-size: 20px;
            background: white;
            padding: 5px 11px;
            border-radius: 50%;
            color: #000000b3;
        }
        .mcc {
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            text-align: center;
            font-size: 1.2rem;
        }
        .navbar {
            padding: 0;
        }
        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        .navbar .container-fluid {
            display: flex;
            align-items: center;
        }
        .navbar .container-fluid > div {
            display: flex;
            align-items: center;
        }
        .navbar .container-fluid .col-md-1 img {
            width: 70px;
        }
        .navbar .container-fluid .col-md-2 {
            justify-content: flex-end;
        }
        .navbar .container-fluid .col-md-2 a {
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }
        .navbar .container-fluid .notification {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 1rem;
            cursor: pointer;
            position: relative;
        }
        .notification .notification-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark fixed-top" style="background-color: #2a2f5b;">
    <div class="container-fluid mt-2 mb-2 navbar-content">
        <div class="col-md-1">
            <img src="img/mcc1.png" alt="MCC Logo">
        </div>
        <div class="mcc">
            <p>MADRIDEJOS COMMUNITY COLLEGE FILE AND DOCUMENT TRACKER</p>
        </div>
       
        <div class="col-md-2" style="justify-content: flex-end;">
        <div class="notification" onclick="showNotifications();" id="notificationBell">
            <i class="fas fa-bell"></i>
            <span id="notificationCount" class="notification-count"></span>
        </div>
            <a class="text-light" href="#" onclick="logout();"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
        </div>
    </div>
</nav>

<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<script>
    function logout() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to log out.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log me out!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to logout action
                window.location.href = 'ajax.php?action=logout';
            }
        });
    }

    function showNotifications() {
        fetchNotifications();
    }

    function fetchNotifications() {
        fetch('fetch_notifications.php')
            .then(response => response.json())
            .then(data => {
                let notificationCount = data.length;
                document.getElementById('notificationCount').textContent = notificationCount > 0 ? notificationCount : '';

                let notificationsList = '';
                if (data.length > 0) {
                    notificationsList = '<ul>';
                    data.forEach(notification => {
                        notificationsList += `<li>${notification.message} - ${new Date(notification.date_created).toLocaleString()}</li>`;
                    });
                    notificationsList += '</ul>';
                } else {
                    notificationsList = '<p>No new notifications.</p>';
                }
                Swal.fire({
                    title: 'Notifications',
                    html: notificationsList,
                    icon: 'info',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        markNotificationsAsRead();
                    }
                });
            });
    }

    function markNotificationsAsRead() {
        fetch('mark_notifications_as_read.php', { method: 'POST' })
            .then(() => {
                // After marking as read, fetch the notifications again to update the count
                fetchNotifications();
            });
    }

    document.addEventListener('DOMContentLoaded', fetchNotifications);
</script>

</body>
</html>
