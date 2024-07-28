<?php
  if(!isset($_SESSION['login_id']))
  header('location:login.php');
?>

<nav id="sidebar" class='mx-lt-5' style="background-color: #2a2f5b;" >
		
		<div class="sidebar-list">

				<a href="indexs.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
				<a href="indexs.php?page=view_requests" class="nav-item nav-files"><span class='icon-field'><i class="fa fa-file"></i></span> Status Request</a>
				<a href="indexs.php?page=all_request" class="nav-item nav-form"><span class='icon-field'><i class="fa fa-file"></i></span> All Request</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="indexs.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>