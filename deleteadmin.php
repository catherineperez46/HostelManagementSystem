<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>

<?php
	if (isset($_GET["id"])){
		$idfromurl = $_GET["id"];
		$connection;
		$query = "DELETE FROM admin WHERE id = '$idfromurl'";
		$execute = mysqli_query($connection, $query);
		if($execute){
			$_SESSION["SuccessMessage"] = "Admin Deleted Successfully";
			Redirect_to("admins.php");
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
			Redirect_to("admins.php");
		}
	}
?>
