<?php
// Include the database connection
include('db_connect.php');
if(!isset($_SESSION['login_id']))
header('location:login.php');

// Initialize variables
$requests_today = 0;
$requests_week = 0;
$requests_month = 0;

// Initialize status counts
$pending_count = 0;
$rejected_count = 0;
$released_count = 0;
$on_process_count = 0;

// Count requests by day
$result_today = $conn->query("SELECT COUNT(*) as count FROM request WHERE DATE(date_created) = CURDATE()");
if ($result_today) {
    $requests_today = $result_today->fetch_assoc()['count'];
} else {
    echo "Error retrieving requests for today: " . $conn->error;
}

// Count requests by week
$result_week = $conn->query("SELECT COUNT(*) as count FROM request WHERE YEARWEEK(date_created, 1) = YEARWEEK(CURDATE(), 1)");
if ($result_week) {
    $requests_week = $result_week->fetch_assoc()['count'];
} else {
    echo "Error retrieving requests for this week: " . $conn->error;
}

// Count requests by month
$result_month = $conn->query("SELECT COUNT(*) as count FROM request WHERE YEAR(date_created) = YEAR(CURDATE()) AND MONTH(date_created) = MONTH(CURDATE())");
if ($result_month) {
    $requests_month = $result_month->fetch_assoc()['count'];
} else {
    echo "Error retrieving requests for this month: " . $conn->error;
}

// Count requests by status
$result_status = $conn->query("SELECT status, COUNT(*) as count FROM request GROUP BY status");
if ($result_status) {
    while ($row = $result_status->fetch_assoc()) {
        switch ($row['status']) {
            case 'pending':
                $pending_count = $row['count'];
                break;
            case 'rejected':
                $rejected_count = $row['count'];
                break;
            case 'released':
                $released_count = $row['count'];
                break;
            case 'on_process':
                $on_process_count = $row['count'];
                break;
        }
    }
} else {
    echo "Error retrieving request status counts: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />
  <title>Dashboard - MCC Document Tracker</title>
  <style>
    .container {
      width: 100%;
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card {
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .card h4 {
      margin: 0;
    }
    .card-body {
      padding: 15px;
    }
    .text-white {
      color: #fff;
    }
    .bg-success {
      background-color: #28a745;
    }
    .text-right {
      text-align: right;
    }
    canvas {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Dashboard</h1>
    <div class="row">
      <div class="col-md-4">
        <div class="card bg-success text-white">
          <div class="card-body" style="background-color: #2a2f5b;">
            <h4><b>Requests Today</b></h4>
            <hr>
            <h3 class="text-right"><b><?php echo $requests_today; ?></b></h3>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-success text-white">
          <div class="card-body" style="background-color: #2a2f5b;">
            <h4><b>Requests This Week</b></h4>
            <hr>
            <h3 class="text-right"><b><?php echo $requests_week; ?></b></h3>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-success text-white">
          <div class="card-body" style="background-color: #2a2f5b;">
            <h4><b>Requests This Month</b></h4>
            <hr>
            <h3 class="text-right"><b><?php echo $requests_month; ?></b></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <canvas id="requestChart"></canvas>
      </div>
      <div class="col-md-6">
        <canvas id="statusChart"></canvas>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var ctx = document.getElementById('requestChart').getContext('2d');
    var requestChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Today', 'This Week', 'This Month'],
        datasets: [{
          label: 'Requests',
          data: [<?php echo $requests_today; ?>, <?php echo $requests_week; ?>, <?php echo $requests_month; ?>],
          backgroundColor: [
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)'
          ],
          borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctxStatus = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(ctxStatus, {
      type: 'pie',
      data: {
        labels: ['Pending', 'Rejected', 'Released', 'On Process'],
        datasets: [{
          label: 'Request Statuses',
          data: [<?php echo $pending_count; ?>, <?php echo $rejected_count; ?>, <?php echo $released_count; ?>, <?php echo $on_process_count; ?>],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
          ],
          borderWidth: 1
        }]
      }
    });
  </script>
</body>
</html>
