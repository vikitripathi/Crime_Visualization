<?php

	$con = @mysqli_connect("127.0.0.1","root","","DBMS_Project_Final");
	if (mysqli_connect_errno()){
		die("Failed to connect to MySQL: " . mysqli_connect_error());
	}
?>
