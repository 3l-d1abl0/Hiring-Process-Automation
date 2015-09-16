<?php

	$host="localhost";
	$uname="root";
	$p="$!roothost666;";
	$db="rec";

	$con=mysqli_connect($host,$uname,$p,$db);


	if(mysqli_connect_errno()){
		//echo "Failed to conn.".mysqli_connect_error();
		echo "Failed To Connect...!";
		exit();
	}
	/*
	else{
		echo "Connected!";
	}
	*/
?>