<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>
<?php  Confirm_login(); ?>

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
	<title> Post </title>
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
				<h1> Post </h1>
				</div>

				<?php
				global $connection;
				if (isset($_GET["Searchbutton"])){
					$search = $_GET["Search"];
					$viewquery ="SELECT * FROM admin_panel WHERE dateTime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
				}
				elseif (isset($_GET["page"])){
						$page = $_GET["page"];
						if($page == 0 || $page < 1){
							$showpostfrom = 0;
						}else{
							$showpostfrom = ($page * 5) - 5;
						}

						$viewquery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT $showpostfrom,5";
				}
				else{
				$viewquery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5";}
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
						<p class="post"><?php 
						if(strlen($post)>150){$post = substr($post,0,150).'...';}
						echo $post; ?></p>
					</div>
					<a href="studentfullpost.php?id=<?php echo $postid; ?>"><span class="btn btn-info">
						Read More &rsaquo;&rsaquo;&rsaquo;
					</span>
					</a> 
				</div>
				<?php } ?>

				<nav>
					<ul class="pagination pagination-md justify-content-center">
				<?php
				if(isset($page)){
				if($page > 1){
					?>
					<li class="page-item"><a class="page-link" href="studentpost.php?page=<?php echo $page-1; ?>"> &laquo; </a></li>
				<?php 	}
				}
				?>
				<?php
				global $connection;
				$querypagination = "SELECT COUNT(*) FROM admin_panel";
				$executepagination = mysqli_query($connection, $querypagination);
				$rowpagination = mysqli_fetch_array($executepagination);
				$totalposts = array_shift($rowpagination);
				$postpagination = $totalposts/5;
				$postpagination = ceil($postpagination);

				for($i=1; $i <= $postpagination; $i++){
				if(isset($page)){
					if($i == $page){
					?>
				<li class="page-item active"><a class="page-link" href="studentpost.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php 
				}else{ ?>
				<li class="page-item"><a class="page-link" href="studentpost.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php 
				}
				}
				} ?>
 
				<?php
				if(isset($page)){
				if($page + 1 <= $postpagination){
					?>
					<li class="page-item"><a class="page-link" href="studentpost.php?page=<?php echo $page+1; ?>"> &raquo; </a></li>
				<?php 	}
				}
				?>
					</ul>
				</nav><!--end pagination-->

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