<?php

			$host="localhost";
			$database="rec";
			$username="root";
			$password="#!roothost666;";


		 $con=mysqli_connect($host,$username,$password,$database);


		 // Check connection
			if (!$con) {
			    die("Connection failed: " . mysqli_connect_error());
			}


?>