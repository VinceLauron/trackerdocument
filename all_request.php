<?php
include 'db_connect.php';

// Fetch all requests
$result_all_requests = $conn->query("SELECT * FROM request ORDER BY date_created DESC");
$all_requests = [];
if ($result_all_requests) {
    while ($row = $result_all_requests->fetch_assoc()) {
        $all_requests[] = $row;
    }
} else {
    echo "Error retrieving all requests: " . $conn->error;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .input-group {
        width: 100%;
        margin-bottom: 20px;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    .action-buttons button {
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        color: #fff;
        border-radius: 4px;
    }
    .view-btn {
        background-color: #007bff;
    }
    .print-btn {
        background-color: #28a745;
    }
    #pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }
    #pagination button {
        padding: 5px 10px;
        margin: 0 5px;
        cursor: pointer;
    }
    #pageDisplay {
        margin: 0 10px;
    }
</style>
<div class="container">
    <h2>All Requests</h2>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-4 input-group ml-auto">
                <input type="text" class="form-control" id="search" aria-label="Search" aria-describedby="inputGroup-sizing-sm" placeholder="Search...">
                <div class="input-group-append">
                    <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    <table id="requestsTable">
        <thead>
            <tr>
                <th>ID Number</th>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Course</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($all_requests) > 0): ?>
                <?php foreach ($all_requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['id_number']); ?></td>
                        <td><?php echo htmlspecialchars($request['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($request['contact']); ?></td>
                        <td><?php echo htmlspecialchars($request['course']); ?></td>
                        <td><?php echo htmlspecialchars($request['docu_type']); ?></td>
                        <td><?php echo htmlspecialchars($request['purpose']); ?></td>
                        <td><?php echo htmlspecialchars($request['date_created']); ?></td>
                        <td><?php echo htmlspecialchars($request['status']); ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="view-btn" data-toggle="modal" data-target="#viewModal" onclick="setModalData(<?php echo htmlspecialchars(json_encode($request)); ?>)">View</button>
                                <button class="print-btn" data-toggle="modal" data-target="#printModal" onclick="setPrintData(<?php echo htmlspecialchars(json_encode($request)); ?>)">Print</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No requests found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div id="pagination">
        <button class="btn-primary" id="prevPage" onclick="prevPage()">Previous</button>
        <span id="pageDisplay"></span>
        <button class="btn-primary" id="nextPage" onclick="nextPage()">Next</button>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">View Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
            <tr>
                <th>ID Number</th>
                <td id="view-id-number"></td>
            </tr>
            <tr>
                <th>Full Name</th>
                <td id="view-fullname"></td>
            </tr>
            <tr>
                <th>Contact</th>
                <td id="view-contact"></td>
            </tr>
            <tr>
                <th>Course</th>
                <td id="view-course"></td>
            </tr>
            <tr>
                <th>Document Type</th>
                <td id="view-docu-type"></td>
            </tr>
            <tr>
                <th>Purpose</th>
                <td id="view-purpose"></td>
            </tr>
            <tr>
                <th>Date Created</th>
                <td id="view-date-created"></td>
            </tr>
            <tr>
                <th>Status</th>
                <td id="view-status"></td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="printModalLabel">Print Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Dynamic content will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="printCurrentRequest()">Print</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    let currentPage = 1;
    const rowsPerPage = 5;
    const table = document.getElementById('requestsTable');
    const rows = Array.from(table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'));

    function displayPage(page, filteredRows) {
        const rowsToDisplay = filteredRows || rows;
        const totalPages = Math.ceil(rowsToDisplay.length / rowsPerPage);

        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = 'none';
        }

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        for (let i = start; i < end && i < rowsToDisplay.length; i++) {
            rowsToDisplay[i].style.display = '';
        }

        document.getElementById('pageDisplay').textContent = `Page ${page} of ${totalPages}`;
    }

    function updatePagination(filteredRows) {
        currentPage = 1;
        displayPage(currentPage, filteredRows);
    }

    function nextPage() {
        const filteredRows = getFilteredRows();
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

        if (currentPage < totalPages) {
            currentPage++;
            displayPage(currentPage, filteredRows);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            displayPage(currentPage, getFilteredRows());
        }
    }

    function getFilteredRows() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        return rows.filter(row => row.textContent.toLowerCase().includes(searchTerm));
    }

    document.getElementById('search').addEventListener('keyup', function() {
        updatePagination(getFilteredRows());
    });

    displayPage(currentPage);

    function setModalData(request) {
        document.getElementById('view-id-number').textContent = request.id_number;
        document.getElementById('view-fullname').textContent = request.fullname;
        document.getElementById('view-contact').textContent = request.contact;
        document.getElementById('view-course').textContent = request.course;
        document.getElementById('view-docu-type').textContent = request.docu_type;
        document.getElementById('view-purpose').textContent = request.purpose;
        document.getElementById('view-date-created').textContent = request.date_created;
        document.getElementById('view-status').textContent = request.status;
    }

    function setPrintData(request) {
        const modalBody = document.querySelector('#printModal .modal-body');
        modalBody.innerHTML = `
            <div style="text-align: center;">
                <h1>PRINT RECEIPT</h1>
                <p>MADRIDEJOS COMMUNITY COLLEGE<p>
                <p>Bunakan, Madridejos, Cebu<p>
                <img src="img/mcc1.png" style="height: auto; width: 200px; float: right;">
                <div style="clear: both;"></div>
                <table class="table table-bordered" style="margin-top: 20px;">
                    <tr>
                        <th>ID Number</th>
                        <td>${request.id_number}</td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td>${request.fullname}</td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td>${request.course}</td>
                    </tr>
                    <tr>
                        <th>Document Type</th>
                        <td>${request.docu_type}</td>
                    </tr>
                </table><br><br><br><br>
                <p style="float: left;">___________________________<p>  <p style="float: right;">___________________________<p><br>
                <p style="float: left;">Student Name<p>  <p style="float: right;">Registrar<p>
            </div>
        `;
    }

    function printCurrentRequest() {
        const printContent = document.querySelector('#printModal .modal-body').innerHTML;
        const newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"></head><body onload="window.print()">' + printContent + '</body></html>');
        newWin.document.close();
        setTimeout(function() {
            newWin.close();
        }, 10);
    }
</script>
