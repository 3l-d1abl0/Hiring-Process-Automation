<?php

		include('connect.php');

		
		if(!isset($_POST['interid'])){
			return 0;
		}
		

		$id=$_POST['interid'];
		//$id="E6-1438419600";
		//$id="E1-1454671380";
		//$id="E7-1471255200";
		$det=explode("-", $id);
		$id=$det[0].$det[1];
		
		//$id="temp";	


				$qq="SELECT 1 FROM ".$id." LIMIT 1";
				//echo $qq."<br>";

				if($result=mysqli_query($con,$qq)){

					echo 1;
					//table is present
					//echo mysqli_num_rows($result);
				}
				else{

					//echo 0	;
					//table does not exist, so creating

					$tbl="CREATE TABLE ".$id." (
								id INT(5),
								ques varchar(100),
								ans int(5)
								)";
					//echo $tbl;
					
					if($res=mysqli_query($con,$tbl)){
						//echo "created";
						echo 1;
					}
					else{
						//echo "couldnt";
						echo 0;
					}
					
				}





		





				/*

						$q="SELECT 1 FROM (?) LIMIT 1";

		if($stmt=mysqli_prepare($con,$q)){
					

				mysqli_stmt_bind_param($stmt, "s",$id);

				mysqli_stmt_execute($stmt);

				mysqli_stmt_bind_result($stmt, $one);

				mysqli_stmt_fetch($stmt);

        		mysqli_stmt_close($stmt);
    			
    			echo "10";

			}
			else{
				echo "creating table";
				$error=mysqli_error($con);

				$tbl="CREATE TABLE ".$id." (
						id INT(5),
						ques varchar(100),
						ans int(5)
						)";
				//echo $tbl;
					
				if($res=mysqli_query($con,$tbl)){
					//echo "created";
					echo 1;
				}
				else{
						//echo "couldnt";
						echo 0;
				}	

		
			}




				*/



?>