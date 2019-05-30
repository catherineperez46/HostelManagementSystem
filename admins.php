<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>
<?php  Confirm_login(); ?>

<?php
	if(isset($_POST["Submit"])){
		global $connection;
		$fullName = mysqli_real_escape_string($connection,$_POST["FullName"]);
		$userName = mysqli_real_escape_string($connection,$_POST["UserName"]);
		$employeeId = mysqli_real_escape_string($connection,$_POST["EmployeeId"]);
		$gender = mysqli_real_escape_string($connection,$_POST["Gender"]);
		$phoneNo = mysqli_real_escape_string($connection,$_POST["PhoneNo"]);
		$email = mysqli_real_escape_string($connection,$_POST["Email"]);
		$password = mysqli_real_escape_string($connection,$_POST["Password"]);
		$confirmPassword = mysqli_real_escape_string($connection,$_POST["ConfirmPassword"]);
		$photo = mysqli_real_escape_string($connection,$_POST["Photo"]);

		date_default_timezone_set("Africa/Dar_es_Salaam");
		$currentTime = time();
		$dateTime = strftime("%B %d, %Y %H:%M:%S" , $currentTime);
		$dateTime;
		$Admin = $_SESSION["userName"];

		$photo = $_FILES["Photo"]["name"];
		$target = "upload/".basename($_FILES["Photo"]["name"]);


		if (empty($fullName) || empty($userName) || empty($employeeId) || empty($gender) || empty($phoneNo) || empty($email) || empty($password) || empty($confirmPassword)){
			$_SESSION["ErrorMessage"] = "All Fields must be filled out";
			Redirect_to("admins.php");
		}elseif(strlen($password) < 4){
			$_SESSION["ErrorMessage"] = "Atleast 4 Characters For Password are required";
			Redirect_to("admins.php");
		}elseif($password !== $confirmPassword){
			$_SESSION["ErrorMessage"] = "Password / ConfirmPassword does not match";
			Redirect_to("admins.php");
		}else{
			global $connection;
			$query= "INSERT INTO admin (datetime, fullName, userName, employeeId, gender, phoneNo, email, password, confirmPassword, photo, addedBy) VALUES ('$dateTime', '$fullName', '$userName', '$employeeId', '$gender', '$phoneNo', '$email', '$password', '$confirmPassword', '$photo', '$Admin')";
			$execute=mysqli_query($connection,$query);
			move_uploaded_file($_FILES["Photo"]["tmp_name"], $target);

			if($execute){
				$_SESSION["SuccessMessage"] = "Admin Added Successfully";
				Redirect_to("admins.php");
			}else{
				$_SESSION["ErrorMessage"] = "Admin failed to Add";
				Redirect_to("admins.php");
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
	<title> Manage Admins </title>
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
					<li class="nav-item "><a class="nav-link" href="admindashboard.php">
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
					<li class="nav-item"><a class="nav-link active" href="admins.php">
					<span class="glyphicon glyphicon-user"></span> &nbsp;Manage Admins </a></li><br>
					<li class="nav-item"><a class="nav-link" href="rooms.php">
					<span class="glyphicon glyphicon-bed"></span> &nbsp;Room </a></li><br>
					<li class="nav-item"><a class="nav-link" href="logout.php">
					<span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout </a></li><br>
				</ul>
			</div><!-- end col-sm-2-->
			
			<div class="col-sm-10"><br>

				<h1> Add New Admin </h1>
				<div>
					<?php
					echo ErrorMessage();
					echo SuccessMessage();
					?>
				</div><!--messages-->

				<div>
					<form action="admins.php" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-row">
							<div class="form-group col-sm-6">
							<label for="fullName"><span class="fieldinfo"> Full Name: </span></label>
							<input class="form-control" type="text" name="FullName" id="fullName" placeholder="Full Name">
						    </div>
						    <div class="form-group col-sm-6">
							<label for="userName"><span class="fieldinfo"> User Name: </span></label>
							<input class="form-control" type="text" name="UserName" id="userName" placeholder="User Name">
						    </div>
							</div>
						    <div class="form-group col-sm-6">
							<label for="employeeId"><span class="fieldinfo"> Employee Id: </span></label>
							<input class="form-control" type="text" name="EmployeeId" id="employeeId" placeholder="Employee Id">
						    </div>
						    <div class="form-group col-sm-4">
							<label for="gender"><span class="fieldinfo"> Gender: </span></label>
							<select class="form-control" name="Gender" id="gender" placeholder="Gender">
								<option>Male</option>
								<option>Female</option>
							</select>
						    </div>
						    <div class="form-row">
						    <div class="form-group col-sm-6">
							<label for="phoneNo"><span class="fieldinfo"> Phone No: </span></label>
							<input class="form-control" type="text" name="PhoneNo" id="phoneNo" placeholder="Phone No">
						    </div>
						    <div class="form-group col-sm-6">
							<label for="email"><span class="fieldinfo"> Email: </span></label>
							<input class="form-control" type="email" name="Email" id="email" placeholder="Email">
						    </div>
							</div>
							<div class="form-row">
						    <div class="form-group col-sm-6">
							<label for="password"><span class="fieldinfo"> Password: </span></label>
							<input class="form-control" type="password" name="Password" id="password" placeholder="Password">
						    </div>
						    <div class="form-group col-sm-6">
							<label for="confirmPassword"><span class="fieldinfo"> Confirm Password: </span></label>
							<input class="form-control" type="password" name="ConfirmPassword" id="confirmPassword" placeholder="Retype same Password">
						    </div>
							</div>
						    <div class="form-group col-sm-4">
							<label for="photo"><span class="fieldinfo"> Photo: </span></label>
							<input class="form-control" type="file" name="Photo" id="photo" placeholder="Photo">
						    </div>

						    <br>
						    <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
						</fieldset>
						<br>
					</form>
				</div> <!--end form-->
				<br><hr><br>
				<form action="admins.php" class="navbar-form navbar-right">
			  	  <div class="input-row" id="search">
				    <div class="input-group">
					  <input class="form-control" type="text" name="Search" placeholder="Search">
				 	 <div class="input-group-append">
				      <button class="btn btn-info" name="Searchbutton"> GO </button>
				     </div>
				    </div>
			      </div>
				</form>
				<br>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th> Sr No </th>
							<th> Photo </th>
							<th> Full Name </th>
							<th> User Name </th>
							<th> Employee Id </th>
							<th> Gender </th>
							<th> Phone No </th>
							<th> Email </th>
							<th> Date & Time </th>
							<th> Added By </th>
							<th> Action </th>
						</tr>
							<?php
								global $connection;
								if (isset($_GET["Searchbutton"])){
								$search = $_GET["Search"];
								$viewquery ="SELECT * FROM admin WHERE fullName LIKE '%$search%' OR userName LIKE '%$search%' OR employeeId LIKE '%$search%' OR gender LIKE '%$search%' OR email LIKE '%$search%' OR dateTime LIKE '%$search%'";
								}else{
								$viewquery = "SELECT * FROM admin ORDER BY id desc";}
								$execute = mysqli_query($connection,$viewquery);

								$srNo =0;
								while($dataRows = mysqli_fetch_array($execute)){
									$id = $dataRows["id"];
									$photo = $dataRows["photo"];
									$fullName = $dataRows["fullName"];
									$userName = $dataRows["userName"];
									$employeeId = $dataRows["employeeId"];
									$gender = $dataRows["gender"];
									$phoneNo = $dataRows["phoneNo"];
									$email = $dataRows["email"];
									$dateTime = $dataRows["dateTime"];
									$Admin = $dataRows["addedBy"];
									$srNo ++;
							?>
							<tr>
								<td><?php echo $srNo; ?></td>
								<td><img id="img" class="img-responsive img-rounded" src="upload/<?php echo $photo; ?>"></td>
								<td><?php echo $fullName; ?></td>
								<td><?php echo $userName; ?></td>
								<td><?php echo $employeeId; ?></td>
								<td><?php echo $gender; ?></td>
								<td><?php echo $phoneNo; ?></td>
								<td><?php echo $email; ?></td>
								<td><?php echo $dateTime; ?></td>
								<td><?php echo $Admin; ?></td>
								<td><a href="deleteadmin.php?id=<?php echo $id; ?>">
								<span class="btn btn-danger btn-md">Delete</span> 
								 </a></td>
							</tr>
							<?php }?>
					</table>
				</div><!--end main body-->

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