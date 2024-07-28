<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('location:login.php');
    exit();
}
?>

<?php include 'sidebar.php' ?>
<?php include 'topbar.php' ?>

<center><div class="" id="welcome-message">
    <h1>Welcome, <?php echo $_SESSION['fullname']; ?>!</h1>
    <p>You have successfully logged in</p>
</div></center>


<script>
    function loadContent(page) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', page, true);
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('main-content').innerHTML = this.responseText;
                document.getElementById('welcome-message').style.display = 'none';
            }
        };
        xhr.send();
    }
</script>
