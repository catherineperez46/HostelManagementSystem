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
	<title> Comments </title>
</head>
<body>

 <div class="line"></div>
  <div style="height: 60px; background: #211f22;">
	  <nav class="navbar navbar-inverse" role="navigation">
		  <div class="container">
			  <div class="navbar-header">
				  <a class="navbar-brand" href="dashboard.php">
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
					<li class="nav-item"><a class="nav-link" href="admindashboard.php">
					<span class="glyphicon glyphicon-dashboard"></span> &nbsp;Dashboard </a></li><br>
					<li class="nav-item"><a class="nav-link" href="addnewpost.php">
					<span class="glyphicon glyphicon-pencil"></span> &nbsp;Add New Post </a></li>
					<li class="nav-item"><a class="nav-link" href="adminpost.php">
					<span class="glyphicon glyphicon-list-alt"></span> &nbsp;Post </a></li><br>
					<li class="nav-item"><a class="nav-link active" href="comments.php">
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
					<li class="nav-item"><a class="nav-link" href="rooms.php">
					<span class="glyphicon glyphicon-bed"></span> &nbsp;Room </a></li><br>
					<li class="nav-item"><a class="nav-link" href="logout.php">
					<span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout </a></li><br>
				</ul>
			</div><!-- end col-sm-2-->

			<div class="col-sm-10"><br>
				<div><?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?></div>

				<h1> Manage Comments </h1>
				<div class="table-responsive">
				  <table class="table table-striped table-hover">
					<tr>
						<th>No.</th>
						<th>Date</th>
						<th>Name</th>
						<th>Email</th>
						<th>Comment</th>
						<th>Check</th>
						<th>Delete</th>
						<th>Details</th>
					</tr>

					<?php
					$connection;
					$query = "SELECT * FROM comment WHERE status = 'ON' ORDER BY id desc";
					$execute = mysqli_query($connection, $query);
					$srNo = 0;
					while($dataRows = mysqli_fetch_array($execute)){
					$commentid = $dataRows['id'];
					$datetimeofcomment = $dataRows['dateTime'];
					$personname = $dataRows['name'];
					$personemail = $dataRows['email'];
					$personcomment = $dataRows['comment'];
					$commentedpostid = $dataRows['admin_panel_id'];
					$srNo++;
						
					?>
					<tr>
						<td><?php echo htmlentities($srNo); ?></td>
						<td><?php echo htmlentities($datetimeofcomment); ?></td>
						<td style="color: blue;"><?php echo htmlentities($personname); ?></td>
						<td><?php echo htmlentities($personemail); ?></td>
						<td><?php echo htmlentities($personcomment); ?></td>
						<td><a href="checkcomments.php?id=<?php echo $commentid; ?>">
						<span class="btn btn-info"> Check </span></a></td>
						<td><a href="deletecomments.php?id=<?php echo $commentid; ?>">
						<span class="btn btn-danger"> Delete </span></a></td>
						<td><a href="adminfullpost.php?id=<?php echo $commentedpostid; ?>" target = "_blank">
						<span class="btn btn-primary"> Preview </span></a></td>
					</tr> 
				<?php } ?>

					</table>
				</div>
				<br><br><hr><br><br>

				<h1> Checked Comments </h1>
				<div class="table-responsive">
				  <table class="table table-striped table-hover">
					<tr>
						<th>No.</th>
						<th>Date</th>
						<th>Name</th>
						<th>Email</th>
						<th>Comment</th>
						<th>Delete</th>
						<th>Details</th>
					</tr>

					<?php
					$connection;
					$query = "SELECT * FROM comment WHERE status = 'OFF' ORDER BY id desc";
					$execute = mysqli_query($connection, $query);
					$srNo = 0;
					while($dataRows = mysqli_fetch_array($execute)){
					$commentid = $dataRows['id'];
					$datetimeofcomment = $dataRows['dateTime'];
					$personname = $dataRows['name'];
					$personemail = $dataRows['email'];
					$personcomment = $dataRows['comment'];
					$commentedpostid = $dataRows['admin_panel_id'];
					$srNo++;
						
					?>
					<tr>
						<td><?php echo htmlentities($srNo); ?></td>
						<td><?php echo htmlentities($datetimeofcomment); ?></td>
						<td style="color: blue;"><?php echo htmlentities($personname); ?></td>
						<td><?php echo htmlentities($personemail); ?></td>
						<td><?php echo htmlentities($personcomment); ?></td>
						<td><a href="deletecomments.php?id=<?php echo $commentid; ?>">
						<span class="btn btn-danger"> Delete </span></a></td>
						<td><a href="adminfullpost.php?id=<?php echo $commentedpostid; ?>" target = "_blank">
						<span class="btn btn-primary"> Preview </span></a></td>
					</tr> 
				<?php } ?>

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