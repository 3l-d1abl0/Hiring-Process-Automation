<?php

	$val=$_POST['val'];

	$arr=array();
	for($i=1;$i<=2;$i++){

		$arr[$i]=$_POST['n'.$i];

	}

	echo $val."<br>";
	echo $arr[1]."<br>";
	echo $arr[2]."<br>";



?>