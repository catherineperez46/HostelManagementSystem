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
			$editfromurl = $_GET['edit'];
			$query= "UPDATE admin_panel SET dateTime = '$dateTime', title = 'title', category = '$category', author = '$Admin', image = '$image', post = '$post' WHERE id = '$editfromurl'";
			$execute=mysqli_query($connection,$query);
			move_uploaded_file($_FILES["Image"]["tmp_name"], $target);

			if($execute){
				$_SESSION["SuccessMessage"] = "Post Updated Successfully";
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
	<title> Edit Post </title>
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

	<div class="container-fluid">
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
					<span class="glyphicon glyphicon-comment"></span> &nbsp;Comments </a></li><br>
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
				<h1> Update Post </h1>
				<?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?>

				<div>
					<?php
					$searchqueryparameter = $_GET['edit'];
					$connection;
					$query = "SELECT * FROM admin_panel WHERE id = '$searchqueryparameter'";
					$executequery = mysqli_query($connection, $query);
					while($dataRows = mysqli_fetch_array($executequery)){
						$titletobeupdated = $dataRows['title'];
						$categorytobeupdated = $dataRows['category'];
						$imagetobeupdated = $dataRows['image'];
						$posttobeupdated = $dataRows['post'];
					}

					?>

					<form action="editpost.php?edit=<?php echo $searchqueryparameter; ?>" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="title"><span class="fieldinfo"> Title: </span></label>
								<input value="<?php echo $titletobeupdated; ?>" class="form-control" type="text" name="Title" id="title" placeholder="<?php echo $titletobeupdated; ?>">
						    </div>
						    <div class="form-group">
						    	<span class="fieldinfo"> Existing Category: </span>
						    	<?php echo $categorytobeupdated; ?>
						    	<br>
								<label for="category"><span class="fieldinfo"> Category: </span></label>
								<input class="form-control" type="text" name="Category" id="category" placeholder="<?php echo $categorytobeupdated; ?>"> 
						    </div>
						    <div class="form-group">
						    	<span class="fieldinfo"> Existing Image: </span>
						    	<img src="upload/<?php echo $imagetobeupdated;?>" width=170px; height=70px;>
						    	<br>
								<label for="image"><span class="fieldinfo"> Select Image: </span></label>
								<input class="form-control" type="file" name="Image" id="image" placeholder="<?php echo $imagetobeupdated; ?>">
						    </div>
						    <div class="form-group">
								<label for="post"><span class="fieldinfo"> Post: </span></label>
								<textarea class="form-control" name="Post" id="post" placeholder="<?php echo $posttobeupdated; ?>">
									<?php echo $posttobeupdated; ?>
								</textarea>
						    </div>
						    <br>
						    <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Update Post">
						</fieldset>
						<br>
					</form>
				</div>
							
			</div>
		</div>
	</div>
	
	<div class="line"></div>
	<div id ="main-footer">
		<hr><p> HostelManagementSystem.com |&copy; 2019 ---All Rigtht Reserved. </p>
		<p> &trade;Anna &trade;Cat &trade;Feisal </p><hr>
	</div>
	<div id="footer-bottom"></div>

</body>
</html>