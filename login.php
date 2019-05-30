<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-glyphicons.min.css">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/adminstyles.css">
	<style>
		body {
			background-color: white;
		}
	
	</style>
	<title> Login </title>
</head>
<body>

<div class="line"></div>
  <div style="height: 60px; background: #211f22;">
	  <nav class="navbar navbar-inverse" role="navigation">
		  <div class="container">
			  <div class="navbar-header">
				  <div class="navbar-brand">
				   <span class="glyphicon glyphicon-home"> Hostel Management System</span>
				  </div>
			  </div>
		  </div>
	  </nav>
  </div><!--navbar link brand-->
 <div class="line"></div>
	
	<div class="container-fluid ">
		<div class="row">
		<div class="col-sm-6">
			<img src="images/hostel.jpg" style="margin-top: 50px;" width="600px" height="500px">
		</div>
			
			<div class="col-sm-6">
				<br><br>
				<div><?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?></div>

			<div style="margin-top: -105px; margin-left: 350px;">
			 	<div class="container-fluid">
                  <div class="row">
  		             <div><a href="adminlogin.php">
		               <button type="button" class="btn btn-primary btn-lg">Admin</button>
                      </a></div>
                     <div style="margin-left: 80px;"><a href="studentlogin.php">
		               <button type="button" class="btn btn-primary btn-lg">Student</button>
    	             </a></div>
                  </div>
                </div>
            </div>

            <img src="images/hostel.png" style="margin-top: 50px;" width="600px" height="500px">

			</div><!--end col-sm-4-->
		</div><!--end row-->
	</div><!--end container fluid-->
	
</body>
</html>



