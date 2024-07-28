<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/mcc1.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Home</title>
    <style>
        .container {
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }

        h2, h1, p {
            animation: fadeInUp 2s ease-in-out;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            animation: zoomIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes zoomIn {
            0% { opacity: 0; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <?php include 'topbar.php'; ?>
    <div class="container">
        <h2>Home</h2>
        <img src="assets/img/Madridejos.jpg" alt="Description of Image">
        <h1>MADRIDEJOS COMMUNITY <br> COLLEGE</h1>
        <p>is a higher education institution located in Bunakan, Madridejos, a municipality in the province of Cebu, Philippines. The college was established to provide accessible and affordable education to the local community, focusing on developing skilled professionals who can contribute to the region's socioeconomic growth.</p>
        <img src="assets/img/mcc1.png" alt="Description of Image">
        <h1>MADRIDEJOS COMMUNITY COLLEGE<br> OFFERS COURSES LIKE</h1>
        <img src="assets/img/bsit.jpg" alt="Description of Image"><br>
        <img src="assets/img/bsed.jpg" alt="Description of Image"><br>
        <img src="assets/img/bshm.jpg" alt="Description of Image"><br>
        <img src="assets/img/bsba.jpg" alt="Description of Image">
    </div>
</body>
</html>
