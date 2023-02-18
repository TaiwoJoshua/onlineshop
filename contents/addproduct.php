<?php 
    if($_SESSION['admin'] == "admin"){

	}else{
		$_SESSION['addproduct'] = 1;
		header("location: ./login.php");
	}
?>
        