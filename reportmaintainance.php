<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>
<?php  Confirm_login(); ?>

<?php
	if(isset($_POST["Submit"])){
		global $connection;
		$title = mysqli_real_escape_string($connection,$_POST["Title"]);
		$description = mysqli_real_escape_string($connection,$_POST["Description"]);

		date_default_timezone_set("Africa/Dar_es_Salaam");
		$currentTime = time();
		$dateTime = strftime("%B %d, %Y %H:%M:%S" , $currentTime);
		$dateTime;
		$Student = $_SESSION["userName"];

		if (empty($title) || empty($description)){
			$_SESSION["ErrorMessage"] = "All Fields are required";
		}elseif(strlen($description)>500){
			$_SESSION["ErrorMessage"] = "Only 500 Characters are required in Comment";
		}else{
			global $connection;
			$query = "INSERT INTO maintainance (title, description, dateTime, reportedBy, status, feedback) VALUES ('$title', '$description', '$dateTime', '$Student', 'ON', NULL)";
			$execute = mysqli_query($connection, $query);
			if($execute){
				$_SESSION["SuccessMessage"] = "Maintainance Submitted Successfully";
				Redirect_to("reportmaintainance.php");
			}else{
				$_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
				Redirect_to("reportmaintainance.php");	
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">  
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-glyphicons.min.css">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/adminstyles.css">
	
	<title> Report Maintainance </title>
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
			<div class="col-sm-2"><br><br>
			  <div>
				<img src="images/profile.png" alt="profile picture" id="img" class="rounded-circle">
				<span id="profilename"> &nbsp;<?php echo $_SESSION["userName"]; ?></span>
			  </div>
				<br><br>	
					<ul id="side_menu" class="nav nav-pills flex-column">
					<li class="nav-item"><a class="nav-link" href="studentdashboard.php">
					<span class="glyphicon glyphicon-dashboard"></span> &nbsp;Dashboard </a></li><br>
					<li class="nav-item"><a class="nav-link" href="studentpost.php">
					<span class="glyphicon glyphicon-list-alt"></span> &nbsp;Post </a></li><br>
					<li class="nav-item"><a class="nav-link active" href="reportmaintainance.php">
					<span class="glyphicon glyphicon-wrench"></span> &nbsp;Maintainance </a></li><br>
					<li class="nav-item"><a class="nav-link" href="logout.php">
					<span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout </a></li><br>
				</ul>
			</div><!-- end col-sm-2-->
			
			<div class="col-sm-10"><br> 
				<h1> Report Maintainance </h1>
				<div><?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?></div>

				<div>
					<form action="reportmaintainance.php" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="title"><span class="fieldinfo"> Title: </span></label>
								<input class="form-control" type="text" name="Title" id="title" placeholder="Title">
						    </div>
						   	<div class="form-group">
								<label for="description"><span class="fieldinfo"> Description: </span></label>
								<textarea class="form-control" name="Description" id="description" placeholder="Description"></textarea>
						    </div>
						    <br>
						    <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
						</fieldset>
						<br>
					</form>
				</div>
				<br>

				<h1> Feedback </h1>	
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>Sr.No</th>
							<th>Title</th>
							<th>Desciption</th>
							<th>Reported Date&Time</th>
							<th>Feedback</th>
							<th>Checked By</th>
							<th>Action</th>
						</tr>

				<?php 
				global $connection;
				$extractingfeedbackquery = "SELECT * FROM maintainance WHERE status = 'OFF'";
				$execute = mysqli_query($connection, $extractingfeedbackquery);
				$srNo = 0;
				while ($dataRows = mysqli_fetch_array($execute)){
					$maintainanceid = $dataRows['id'];
					$title = $dataRows['title'];
					$desciption = $dataRows['description'];
					$dateTime = $dataRows['dateTime'];
					$feedback = $dataRows['feedback'];
					$checkedby = $dataRows['checkedBy'];
					$srNo++;
				?>
				<tr>
					<td><?php echo htmlentities($srNo); ?></td>
					<td style="color: blue;"><?php echo htmlentities($title); ?></td>
					<td><?php echo htmlentities($description); ?></td>
					<td><?php echo htmlentities($dateTime); ?></td>
					<td><?php echo htmlentities($feedback); ?></td>
					<td><?php echo htmlentities($checkedBy); ?></td>
					<td><a href="recheckmaintainance.php"><span class="btn btn-warning"> Re-Check </span></a></td>
				</tr> 
				<?php } ?>

				</table>
			</div>       
			<br><br><br>
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