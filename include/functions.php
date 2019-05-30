<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>

<?php
	function Redirect_to($new_location){
		header("Location:".$new_location);
		exit;
	}

	function Admin_login($userName, $password){
		global $connection;
		$query = "SELECT * FROM admin WHERE userName = '$userName' AND password = '$password'";
		$execute = mysqli_query($connection, $query);
		if ($Admin = mysqli_fetch_assoc($execute)){
			return $Admin;
		}else{
			return null;
		}
	}

	function Student_login($userName, $password){
		global $connection;
		$query = "SELECT * FROM student WHERE userName = '$userName' AND password = '$password'";
		$execute = mysqli_query($connection, $query);
		if ($Student = mysqli_fetch_assoc($execute)){
			return $Student;
		}else{
			return null;
		}
	}

	function Login(){
		if (isset($_SESSION["user_id"])){
			return true;
		}
	}
	function Confirm_login(){
		if (!Login()){
			$_SESSION["ErrorMessage"] = "Login Required";
			Redirect_to("login.php");
		}
	} 
?>
