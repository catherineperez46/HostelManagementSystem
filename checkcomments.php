<?php require_once('include/db.php'); ?>
<?php require_once('include/sessions.php'); ?>
<?php require_once('include/functions.php'); ?>

<?php
	if (isset($_GET["id"])){
		$idfromurl = $_GET["id"];
		global $connection;
		$query = "UPDATE comment SET status = 'OFF' WHERE id = '$idfromurl'";
		$execute=mysqli_query($connection,$query);
		if($execute){
			$_SESSION["SuccessMessage"] = "Comment checked Successfully";
			Redirect_to("comments.php");
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
			Redirect_to("comments.php");
		}
	}	
?>
