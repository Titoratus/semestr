<?php
	include("db.php");
	$cur = $_COOKIE["logged"];
	$query = mysqli_query($con, "SELECT subs_curators.sub_id, subjects.sub_name
															 FROM subs_curators
															 INNER JOIN subjects ON subs_curators.sub_id=subjects.id WHERE cur_id='$cur'");
	
	while ($row = mysqli_fetch_array($query)) {
		echo $row["sub_name"]."<br>";
	}
?>