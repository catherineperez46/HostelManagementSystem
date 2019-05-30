<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>
<?php  Confirm_login(); ?>

<?php
	if(isset($_POST["Submit"])){
		global $connection;
		$name = mysqli_real_escape_string($connection,$_POST["Name"]);
		$email = mysqli_real_escape_string($connection,$_POST["Email"]);
		$comment = mysqli_real_escape_string($connection,$_POST["Comment"]);

		date_default_timezone_set("Africa/Dar_es_Salaam");
		$currentTime = time();
		$dateTime = strftime("%B %d, %Y %H:%M:%S" , $currentTime);
		$dateTime;
		$postid = $_GET["id"];

		if (empty($name) || empty($email) || empty($comment)){
			$_SESSION["ErrorMessage"] = "All Fields are required";
		}elseif(strlen($comment)>500){
			$_SESSION["ErrorMessage"] = "Only 500 Characters are required in Comment";
		}else{
			global $connection;
			$postidfromurl = $_GET['id'];
			$query = "INSERT INTO comment (dateTime, name, email, comment, status, admin_panel_id) VALUES ('$dateTime', '$name', '$email', '$comment', 'ON', '$postidfromurl')";
			$execute = mysqli_query($connection, $query);
			if($execute){
				$_SESSION["SuccessMessage"] = "Comment Submitted Successfully";
				Redirect_to("studentfullpost.php?id={$postid}");
			}else{
				$_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
				Redirect_to("studentfullpost.php?id={$postid}");	
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
	<link rel="stylesheet" type="text/css" href="css/poststyles.css">
	<link rel="stylesheet" type="text/css" href="css/adminstyles.css">
	
	<title> Full Post </title>
</head>
<body>

 <div class="line"></div>
  <div style="height: 60px; background: #211f22;">
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header html">
				<a class="navbar-brand" href="studentdashboard.php">
				 <span class="glyphicon glyphicon-home"> Hostel Management System</span>
				</a>
			</div>
		  
			<form action="studentpost.php" class="navbar-form navbar-right">
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
					<li class="nav-item"><a class="nav-link" href="studentdashboard.php">
					<span class="glyphicon glyphicon-dashboard"></span> &nbsp;Dashboard </a></li><br>
					<li class="nav-item"><a class="nav-link active" href="studentpost.php">
					<span class="glyphicon glyphicon-list-alt"></span> &nbsp;Post </a></li><br>
					<li class="nav-item"><a class="nav-link" href="reportmaintainance.php">
					<span class="glyphicon glyphicon-wrench"></span> &nbsp;Maintainance </a></li><br>
					<li class="nav-item"><a class="nav-link" href="logout.php">
					<span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout </a></li><br>
				</ul>
			</div><!-- end col-sm-2-->
			
			<div class="col-sm-7"><br> 
				<div>
				<h1> Full Post </h1>
				</div>

				<div><?php 
					echo ErrorMessage(); 
					echo SuccessMessage();
				?></div>

				<?php
				global $connection;
				if (isset($_GET["Searchbutton"])){
					$search = $_GET["Search"];
					$viewquery ="SELECT * FROM admin_panel WHERE dateTime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
				}
				else{
				$postidfromurl = $_GET["id"];
				$viewquery = "SELECT * FROM admin_panel WHERE id = '$postidfromurl' ORDER BY id desc";}
				$execute = mysqli_query($connection, $viewquery);
				while ($dataRows = mysqli_fetch_array($execute)) {
					$postid = $dataRows["id"];
					$dateTime = $dataRows["dateTime"]; 
					$title = $dataRows["title"];
					$category = $dataRows["category"];
					$Admin = $dataRows["author"];
					$image = $dataRows["image"];
					$post = $dataRows["post"];
				?>
				<div class="blogpost img-thumbnail">
					<img  class="img-responsive img-rounded" style="height: 400px; width: 800px;" src="upload/<?php echo $image; ?>">
					<div class="caption">
						<h1 id="heading"><?php echo htmlentities($title); ?></h1>
						<p class="description"> Category:<?php echo htmlentities($category); ?> Published on <?php echo htmlentities($dateTime); ?>
						</p>
						<p class="post"><?php echo $post; ?></p>
					</div>	
				</div>
				<?php } ?>
				<br><br><br><br>

				<span class="fieldinfo">Comments</span>
				<?php 
				$connection;
				$postidforcomments = $_GET["id"];
				$extractingcommentsquery = "SELECT * FROM comment WHERE admin_panel_id = '$postidforcomments'";
				$execute = mysqli_query($connection, $extractingcommentsquery);
				while ($dataRows = mysqli_fetch_array($execute)){
					$commentdate = $dataRows["dateTime"];
					$commentername = $dataRows["name"];
					$comments = $dataRows["comment"];
				?>
				<div class="commentblock">
					<img style="margin-left: 10px; margin-top: 10px; float: left;" class="pull-left" src="images/profile.png" width=70px; height=70px>
					<p style="margin-left: 90px;" class="commentinfo"><?php echo $commentername; ?></p>
					<p style="margin-left: 90px;" class="description"><?php echo $commentdate; ?></p>
					<p style="margin-left: 90px;" class="comment"><?php echo nl2br($comments); ?></p>
				</div>
				<hr>
				<br>
			<?php } ?>
			
				<br>
				<span class="fieldinfo">Share your thoughts about this post</span>

				<div>
					<form action="studentfullpost.php?id=<?php echo $postid; ?>" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label for="name"><span class="fieldinfo"> Name: </span></label>
								<input class="form-control" type="text" name="Name" id="name" placeholder="Name">
						    </div>
						    <div class="form-group">
								<label for="email"><span class="fieldinfo"> Email: </span></label>
								<input class="form-control" type="email" name="Email" id="email" placeholder="Email">
						    </div>
						   	<div class="form-group">
								<label for="commentarea"><span class="fieldinfo"> Comment: </span></label>
								<textarea class="form-control" name="Comment" id="commentarea" placeholder="Comment"></textarea>
						    </div>
						    <br>
						    <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
						</fieldset>
						<br>
					</form>
				</div>

			</div><!--end col-sm-7-->
			
			<div class="col-sm-3">

				<div class="card border-info" style="margin-top: 80px;">
					<div class="card-header">
						<h2 class="card-title text-center"> Recent Post </h2>
					</div>
					<div class="card-body background">
						<?php
						$connection;
						$viewquery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 0, 5";
						$execute = mysqli_query($connection, $viewquery);
						while($dataRows = mysqli_fetch_array($execute)){
							$id = $dataRows["id"];
							$title = $dataRows["title"];
							$dateTime = $dataRows["dateTime"];
							$image = $dataRows["image"];
							if(strlen($dateTime) > 11){ $dateTime = substr($dateTime, 0, 11);}
							?>
							<div>
								<img class="pull-left" style="margin-top: -10px; margin-left: 10px; float: left;" 
								src="upload/<?php echo htmlentities($image); ?>" width=100; height=100;>
							  <a href="studentfullpost.php?id=<?php echo $id; ?>">
								<p id="heading card-title" style="margin-left: 120px; "><?php echo htmlentities($title); ?>
								</p>
								<p class="description card-text" style="margin-left: 120px; "><?php echo $dateTime ?>
								</p>
							</div>
							  </a>
							  <br>
							  <hr>
						<?php } ?>
					</div>
				</div>

			</div><!--end col-sm-3-->


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