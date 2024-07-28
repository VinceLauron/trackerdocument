<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />

  <title>MCC FILE AND DOCUMENT TRACKER</title>
 	
  <?php include('./header.php'); ?>
  <?php 
    session_start();
    if(isset($_SESSION['login_id']))
    header("location:indexs.php?page=home");
  ?>

</head>
<style>
  body {
    width: 100%;
    height: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: white;
  }
  main#main {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  #login-left {
    display: none;
  }
  .card {
    margin: auto;
  }
  .logo img {
    max-width: 100%;
  }
  @media (min-width: 768px) {
    #login-left {
      display: flex;
      align-items: center;
      justify-content: center;
      background: darkblue;
      color: white;
      width: 50%;
      height: 100vh;
    }
    #login-right {
      width: 50%;
    }
  }
</style>

<body>
  <main id="main" class="alert-info" style="background-color: white;">
    <div id="login-left">
      <div class="logo">
        <img src="img/mcc1.png" alt="MCC Logo">
      </div>
    </div>
    <div id="login-right" class="container" >
      <div class="w-100">
        <h4 class="text-center" style="color:black;"><b>MADRIDEJOS COMMUNITY COLLEGE DOCUMENT TRACKER</b></h4>
        <br>
        <div class="card col-md-8 mx-auto">
          <div class="card-body">
            <form id="login-form">
              <div class="form-group">
                <label for="username" class="control-label" style="color: black">Username</label>
                <input type="email" id="username" name="username" placeholder="Enter Username" class="form-control">
              </div>
              <div class="form-group">
                <label for="password" class="control-label" style="color: black">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
              </div>
              <center><button class="btn btn-primary btn-block">Login</button></center>
              <div class="text-center mt-3">
                <a href="forgot-password.php" id="forgot-password-link">Forgot Password?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#login-form').submit(function(e) {
      e.preventDefault()
      $('#login-form button').attr('disabled', true).html('Logging in...');
      if ($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();
      $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
          console.log(err)
          $('#login-form button').removeAttr('disabled').html('Login');
        },
        success: function(resp) {
          if (resp == 1) {
            location.reload('indexs.php?page=home');
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
            $('#login-form button').removeAttr('disabled').html('Login');
          }
        }
      })
    })
  </script>
</body>

</html>
