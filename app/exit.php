<?php
	if(isset($_COOKIE["logged"])){
		setcookie("logged", "", time() - 3600);
		setcookie("group", "", time() - 3600);
		setcookie("admin", "", time() - 3600);
	}
	
	header("Location: index.php");
?>