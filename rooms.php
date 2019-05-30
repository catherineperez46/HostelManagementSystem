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
	<title> Rooms </title>
</head>
<body>

<div class="line"></div>
  <div style="height: 60px; background: #211f22;">
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header html">
				<a class="navbar-brand" href="dashboard.php">
				 <span class="glyphicon glyphicon-home"> Hostel Management System</span>
				</a>
			</div>
		  
			<form action="rooms.php" class="navbar-form navbar-right">
			   <div class="input-row" id="search">
				<div class="input-group">
					<input class="form-control" type="text" name="Search" placeholder="Search">
				  <div class="input-group-append">
				   <button class="btn btn-info" name="Searchbutton"> GO </button>
				  </div>
				</div>
			   </div>
			</form>
		 </div>
	</nav>
  </div>
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
					<li class="nav-item"><a class="nav-link" href="admindashboard.php">
					<span class="glyphicon glyphicon-dashboard"></span> &nbsp;Dashboard </a></li><br>
					<li class="nav-item"><a class="nav-link" href="addnewpost.php">
					<span class="glyphicon glyphicon-pencil"></span> &nbsp;Add New Post </a></li>
					<li class="nav-item"><a class="nav-link" href="adminpost.php">
					<span class="glyphicon glyphicon-list-alt"></span> &nbsp;Post </a></li><br>
					<li class="nav-item"><a class="nav-link" href="comments.php">
					<span class="glyphicon glyphicon-comment"></span> &nbsp;Comments 
					<?php
						$connection;
						$query = "SELECT COUNT(*) FROM comment WHERE status = 'ON'";
						$execute = mysqli_query($connection, $query);
						$dataRows = mysqli_fetch_array($execute);
						$uncheckedcomments = array_shift($dataRows);
						if ($uncheckedcomments > 0){
						?>
						<span class="btn badge badge-success">
						<?php echo $uncheckedcomments; ?>
						</span>
					<?php } ?>
				    </a></li><br>
					<li class="nav-item"><a class="nav-link" href="maintainance.php">
					<span class="glyphicon glyphicon-wrench"></span> &nbsp;Maintainance </a></li><br>
					<li class="nav-item"><a class="nav-link" href="students.php">
					<span class="glyphicon glyphicon-education"></span> &nbsp;Manage Students </a></li><br>
					<li class="nav-item"><a class="nav-link" href="admins.php">
					<span class="glyphicon glyphicon-user"></span> &nbsp;Manage Admins </a></li><br>
					<li class="nav-item"><a class="nav-link active" href="rooms.php">
					<span class="glyphicon glyphicon-bed"></span> &nbsp;Room </a></li><br>
					<li class="nav-item"><a class="nav-link" href="logout.php">
					<span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout </a></li><br>
				</ul>
			</div><!-- end col-sm-2-->

			<div class="col-sm-10">
				<br>
				<h1> Manage Rooms </h1>
				<div><?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?></div>

				<div class="table-responsive">
					<table class="table table.striped table-hover">
						<tr>
							<th> Room No</th>
							<th> Block </th>
							<th> Student Id </th>
							<th> Student FullName </th>
						</tr>

							<?php
							global $connection;
							if (isset($_GET["Searchbutton"])){
							$search = $_GET["Search"];
							$viewquery ="SELECT * FROM student WHERE roomNo LIKE '%$search%' OR block LIKE '%$search%' OR studentId LIKE '%$search%' OR fullName LIKE '%$search%'";
							}else{
							$viewquery = "SELECT * FROM student ORDER BY roomNo desc";}
							$execute = mysqli_query($connection, $viewquery);
							
							while($dataRows = mysqli_fetch_array($execute)){
							$id = $dataRows["id"];
							$roomNo = $dataRows["roomNo"];
							$block = $dataRows["block"];
							$studentId = $dataRows["studentId"];
							$fullName = $dataRows["fullName"];
						     ?>
							<tr>
								<td><?php echo $roomNo; ?></td>
								<td><?php echo $block; ?></td>
								<td><?php echo $studentId; ?></td>
								<td><?php echo $fullName; ?></td>
							</tr>
						    <?php }?>
							
					</table>
				</div>

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