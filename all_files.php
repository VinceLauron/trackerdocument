<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />

    <title>Files Information</title>
    <style>
        .file {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .file h2 {
            margin-top: 0;
            font-size: 1.4em;
            color: #333;
        }
        .file p {
            margin: 10px 0;
        }
        .file p.fullname {
            text-align: left;
            padding-left: 20px; 
        }
        .file a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 10px;
        }
        .file a:hover {
            background-color: #0056b3;
        }
        .input-group-append {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }
    </style>
</head>
<body>
      if(!isset($_SESSION['login_id']))
    header('location:login.php');
    <h1>Files Information</h1>
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

     <div id="files-container">
        <?php
        include 'db_connect.php';

        if(!isset($_SESSION['login_id']))
        header('location:login.php');
    
        $files_query = $conn->query("SELECT * FROM files ORDER BY fullname ASC");

        while ($file = $files_query->fetch_assoc()) {
            echo '<div class="file">';
            echo '<h2>File Information</h2>';
            echo '<p><strong>File Number:</strong> ' . htmlspecialchars($file['file_number']) . '</p>';
            echo '<p><strong>Filename:</strong> ' . htmlspecialchars($file['name']) . '</p>';
            echo '<p><strong>Uploaded on:</strong> ' . htmlspecialchars($file['date_updated']) . '</p>';
            echo '<p class="fullname"><strong>FullName:</strong> ' . htmlspecialchars($file['fullname']) . '</p>';
            echo '<a href="' . 'download.php?file=' . urlencode($file['file_path']) . '" download>Download</a>';
            echo '</div>';
        }
        ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#searchButton').click(function(){
                searchFiles();
            });

            $('#search').keyup(function(){
                searchFiles();
            });

            function searchFiles() {
                var searchText = $('#search').val().toLowerCase();
                $('.file').each(function(){
                    var fullName = $(this).find('.fullname').text().toLowerCase();
                    if(fullName.includes(searchText)){
                        $(this).show(); 
                    } else {
                        $(this).hide(); 
                    }
                });
            }
        });
    </script>
</body>
</html>
