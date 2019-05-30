<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>
<?php  Confirm_login(); ?>

<?php
	if(isset($_POST["Submit"])){
		global $connection;
		$title = mysqli_real_escape_string($connection,$_POST["Title"]);
		$category = mysqli_real_escape_string($connection,$_POST["Category"]);
		$post = mysqli_real_escape_string($connection,$_POST["Post"]);

		date_default_timezone_set("Africa/Dar_es_Salaam");
		$currentTime = time();
		$dateTime = strftime("%B %d, %Y %H:%M:%S" , $currentTime);
		$dateTime;
		$Admin = $_SESSION["userName"];

		$image = $_FILES["Image"]["name"];
		$target = "upload/".basename($_FILES["Image"]["name"]);

		if (empty($title)){
			$_SESSION["ErrorMessage"] = "Title can't be empty";
			Redirect_to("addnewpost.php");
		}elseif(strlen($title)<2){
			$_SESSION["ErrorMessage"] = "Title should be at-least 2 Characters";
			Redirect_to("addnewpost.php");
		}else{
		global $connection;
		$query= "INSERT INTO admin_panel (dateTime, title, category, author, image, post) VALUES ('$dateTime', '$title', '$category', '$Admin', '$image', '$post')";
		$execute = mysqli_query($connection,$query);
		move_uploaded_file($_FILES["Image"]["tmp_name"], $target);

		if($execute){
		$_SESSION["SuccessMessage"] = "Post Added Successfully";
		Redirect_to("addnewpost.php");
		}else{
		$_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
		Redirect_to("addnewpost.php");
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
	<title> Add New Post </title>
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
					<li class="nav-item"><a class="nav-link active" href="addnewpost.php">
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
					<li class="nav-item"><a class="nav-link" href="rooms.php">
					<span class="glyphicon glyphicon-bed"></span> &nbsp;Room </a></li><br>
					<li class="nav-item"><a class="nav-link" href="logout.php">
					<span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout </a></li><br>
				</ul>
			</div><!-- end col-sm-2-->

			<div class="col-sm-10">
				<br>
				<h1> Add New Posts </h1>
				<div><?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?></div><!--end message-->

				<div>
					<form action="addnewpost.php" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="title"><span class="fieldinfo"> Title: </span></label>
								<input class="form-control" type="text" name="Title" id="title" placeholder="Title">
						    </div>
						    <div class="form-group">
								<label for="category"><span class="fieldinfo"> Category: </span></label>
								<input class="form-control" type="text" name="Category" id="category" placeholder="Category">
						    </div>
						    <div class="form-group">
								<label for="image"><span class="fieldinfo"> Select Image: </span></label>
								<input class="form-control" type="file" name="Image" id="image" placeholder="Image">
						    </div>
						    <div class="form-group">
								<label for="post"><span class="fieldinfo"> Post: </span></label>
								<textarea class="form-control" name="Post" id="post" placeholder="Post"></textarea>
						    </div>
						    <br>
						    <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post">
						</fieldset>
						<br>
					</form>
				</div>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>Sr.No</th>
							<th>Post Title</th>
							<th>Date & Time</th>
							<th>Author</th>
							<th>Category</th>
							<th>Banner</th>
							<th>Comments</th>
							<th>Action</th>
							<th>Details</th>
						</tr>

						<?php
						global $connection;
							$viewquery = "SELECT * FROM admin_panel ORDER BY id desc";
							$execute = mysqli_query($connection, $viewquery);
							$srNo = 0;
							while($dataRows = mysqli_fetch_array($execute)){
								$id = $dataRows["id"];
								$dateTime = $dataRows["dateTime"];
								$title = $dataRows["title"];
								$category = $dataRows["category"];
								$Admin = $dataRows["author"];
								$image = $dataRows["image"];
								$post = $dataRows["post"];
								$srNo++;
								?>

								<tr>
									<td><?php echo $srNo; ?></td>
									<td style="color: blue;"><?php 
									if(strlen($title)>20){$title = substr($title,0,20).'..';}
									echo $title; ?></td>
									<td><?php 
									if(strlen($dateTime)>11){$dateTime = substr($dateTime,0,11).'..';}
									echo $dateTime; ?></td>
									<td><?php 
									if(strlen($Admin)>6){$Admin = substr($Admin,0,11).'..';}
						 			echo $Admin; ?></td>
									<td><?php 
									if(strlen($category)>8){$category = substr($category,0,8).'..';}
									echo $category; ?></td>
									<td><img src="upload/<?php echo $image; ?>" width="150px" height="50px"></td>
									<td>

									<?php
								    $connection;
								    $query = "SELECT COUNT(*) FROM comment WHERE admin_panel_id = '$id'";
									$execute = mysqli_query($connection, $query);
									$dataRows = mysqli_fetch_array($execute);
									$totalcomments = array_shift($dataRows);
									if ($totalcomments > 0){
									?>
									<span class="btn badge-success">
									<?php echo $totalcomments; ?>
									</span>
									<?php } ?>

									</td>
									<td>
										<a href="editpost.php?edit=<?php echo $id; ?>"> 
											<span class="btn btn-warning"> Edit </span>  
										</a>
										<a href="deletepost.php?delete=<?php echo $id; ?>"> 
											<span class="btn btn-danger"> Delete </span>  
										</a>
									</td>
									<td> 
										<a href="fullpost.php?id=<?php echo $id; ?>" target="_blank">
										<span class="btn btn-primary"> Preview </span></td>
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