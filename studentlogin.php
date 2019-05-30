<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>
<?php
	if(isset($_POST["Submit"])){
		global $connection;
		$userName = mysqli_real_escape_string($connection,$_POST["UserName"]);
		$password = mysqli_real_escape_string($connection,$_POST["Password"]);
		
		if(empty($userName) || empty($password)){
			$_SESSION["ErrorMessage"] = "All Fields must be filled out";
			Redirect_to("studentlogin.php");
		}
		else{
				$Found_account = Student_login($userName, $password);
				$_SESSION["user_id"] = $Found_account["id"];
				$_SESSION["userName"] = $Found_account["userName"];
				if($Found_account){
					$_SESSION["SuccessMessage"] = "Login Successfull Welcome {$_SESSION['userName']}";
					Redirect_to("studentdashboard.php");
				}else {
					$_SESSION["ErrorMessage"] = "Invalid Username / Password";
					Redirect_to("studentlogin.php");
				}
			} 
	}
?>
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
	<title> Student Login </title>
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
		<div class="col-sm-7">
			<img src="images/hostel.jpg" style="margin-top: 50px;" width="700px" height="500px">
		</div>
			
			<div class="col-sm-4" style="margin-bottom: 50px;">
				
				<div><a href="studentlogin.php">
					<button class="btn btn-primary btn-lg" style="margin-left: 170px;">Student</button>
				</a></div>

				<br><br>
				
				<div><?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?></div>
			 <div style="margin-top: 70px;">
				<h2> Login </h2>
				<div>
					<form action="studentlogin.php" method="post">
						<fieldset>
							<div class="form-group">
							<label for="userName"><span class="fieldinfo"> UserName: </span></label>
							<div class="input-group">
							<span class="input-group-prepend">
								<span class="glyphicon glyphicon-user text-primary " style="padding: 6px;"></span>
							</span>
							<input class="form-control" type="text" name="UserName" id="userName" placeholder="UserName">
							</div>
						    </div>
						    <div class="form-group">
							<label for="password"><span class="fieldinfo"> Password: </span></label>
							<div class="input-group">
							<span class="input-group-prepend">
								<span class="glyphicon glyphicon-lock text-primary" style="padding: 6px;"></span>
							</span>
							<input class="form-control" type="password" name="Password" id="password" placeholder="Password">
						    </div>
							</div>
						    
						    <br>
						    <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Login">
						</fieldset>
						<br>
					</form>
				 </div>
			</div>
			</div><!--end col-sm-4-->
		</div><!--end row-->
	</div><!--end container fluid-->

	<div class="line"></div>
	<div id ="main-footer">
		<hr><p> HostelManagementSystem.com |&copy; 2019 ---All Rigtht Reserved. </p>
		<p> &trade;Anna &trade;Cat &trade;Feisal </p><hr>
	</div>
	<div id="footer-bottom"></div>
	
</body>
</html>