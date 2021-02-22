<?php
	$con = mysqli_connect("localhost", "root", "", "semester") or die("Ошибка при подключении к БД!");
	$query = mysqli_query($con, "SET NAMES UTF8");
?>