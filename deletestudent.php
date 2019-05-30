<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>

<?php
	if (isset($_GET["id"])){
		$idfromurl = $_GET["id"];
		$connection;
		$query = "DELETE FROM student WHERE id = '$idfromurl'";
		$execute = mysqli_query($connection, $query);
		if($execute){
			$_SESSION["SuccessMessage"] = "Student Deleted Successfully";
			Redirect_to("students.php");
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
			Redirect_to("students.php");
		}
	}
?>
