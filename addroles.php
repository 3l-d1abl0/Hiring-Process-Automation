<?php
	include('connect.php');

	if(!isset($_POST['role'])){
		echo "No Post";
		return;
	}


	$role=$_POST['role'];
	//$role='tech';




				$q="SELECT id,name from empl where role=(?) ORDER BY id";

				if($stmt=mysqli_prepare($con,$q)){
					

						mysqli_stmt_bind_param($stmt, "s",$role);


						mysqli_stmt_execute($stmt);

						mysqli_stmt_bind_result($stmt, $id, $name);


						$arr=array();
						$i=0;

						while (mysqli_stmt_fetch($stmt)) {
							$arr[$i]['id']=$id;
							$arr[$i]['name']=$name;
							$i++;
    					}

        						
    					mysqli_stmt_close($stmt);
    					mysqli_close($con);

    					//return roles to update
    					echo json_encode($arr);
				}
				else{
						$error=mysqli_error($con);
						mysqli_close($con);

						echo 0;
				}


				/*
				//$q="SELECT id,name from empl where role='".$role."'";
				$arr=array();
				$i=0;

				if($result=mysqli_query($con,$q)){

					while($row=mysqli_fetch_assoc($result)){

						//$arr[$row['id']]=$row['name'];
						$arr[$i]['id']=$row['id'];
						$arr[$i]['name']=$row['name'];
						$i++;
					}

					echo json_encode($arr);
				}
				else{
					echo "0";
				}
				*/


?>