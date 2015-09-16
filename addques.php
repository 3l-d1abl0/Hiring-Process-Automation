<?php

	include('connect.php');
	 
	if(!isset($_POST['tbl'])){
		return 0;
	}
	
	$table=$_POST['tbl'];
	//$id="E1-1454671380";

	$qid=$_POST['qid'];
	$ques=$_POST['ques'];

	

	//$table="E1-1454671380";
	$det=explode("-", $table);
	$table=$det[0].$det[1];
	//$qid=2;
	//$ques="etcetra";




	//$qid=3;
	//$ques="Aptitude?";


				
				$qq="SELECT count(*)  as ext FROM `".$table."` WHERE id=".$qid."";

				if($result=mysqli_query($con,$qq)){
					//get count i.e if exits
					$data=mysqli_fetch_assoc($result);
				
					//if there are no questions
					 if($data['ext']==0){

							 	$q="INSERT INTO `".$table."`(`id`, `ques`) VALUES (".$qid.",'".$ques."')";

								 	if($res=mysqli_query($con,$q)){

											echo 1;
									}
									else{
											echo 0;
									}

					  }	//if count 0
					  else{
					  	 //if there are questions
					  	//rewrite question
							  	$q="UPDATE `".$table."` SET `ques`='".$ques."' WHERE id=".$qid."";

							  	if($res=mysqli_query($con,$q)){

											echo 1;
									}
									else{
											echo 0;
									}

					  }
				
				}
				else{
					echo 0;
				}



				


?>