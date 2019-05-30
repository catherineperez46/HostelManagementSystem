<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>
<?php  Confirm_login(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-glyphicons.min.css">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/adminstyles.css">
	<title> Student Dashboard </title>
</head>
<body>

<div class="line"></div>
  <div style="height: 60px; background: #211f22;">
	  <nav class="navbar navbar-inverse" role="navigation">
		  <div class="container">
			  <div class="navbar-header">
				  <a class="navbar-brand" href="studentdashboard.php">
				   <span class="glyphicon glyphicon-home"> Hostel Management System</span>
				  </a>
			  </div>
		  </div>
	  </nav>
  </div><!--navbar link brand-->
  <div class="line"></div>

	<div id="main-content" class="container-fluid">
		<div class="row">
			<div class="col-sm-2" style="height: 450px;"><br><br>
			  <div>
				<img src="images/profile.png" alt="profile picture" id="img" class="rounded-circle">
				<span id="profilename"> &nbsp;<?php echo $_SESSION["userName"]; ?></span>
			  </div>
				<br><br>	
					<ul id="side_menu" class="nav nav-pills flex-column">
					<li class="nav-item"><a class="nav-link active" href="studentdashboard.php">
					<span class="glyphicon glyphicon-dashboard"></span> &nbsp;Dashboard </a></li><br>
					<li class="nav-item"><a class="nav-link" href="studentpost.php">
					<span class="glyphicon glyphicon-list-alt"></span> &nbsp;Post </a></li><br>
					<li class="nav-item"><a class="nav-link" href="reportmaintainance.php">
					<span class="glyphicon glyphicon-wrench"></span> &nbsp;Maintainance </a></li><br>
					<li class="nav-item"><a class="nav-link" href="logout.php">
					<span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout </a></li><br>
				</ul>
			</div><!-- end col-sm-2-->
			
			<div class="col-sm-10"><br>
				<h1> Student Dashboard </h1>
				<div>
					<?php
					echo ErrorMessage();
					echo SuccessMessage();
					?>
				</div><!--messages-->

				

			</div><!--end col-sm-10-->
		</div><!--end row-->
	</div><!--end container-->
	
	<div class="line"></div>
	<div id ="main-footer">
		<hr><p> HostelManagementSystem.com |&copy; 2019 ---All Rigtht Reserved. </p>
		<p> &trade;Anna &trade;Cat &trade;Feisal </p><hr>
	</div>
	<div id="footer-bottom"></div>
</body>
</html>