<?php
	include('connect.php');

	if(!isset($_POST['name'])){

		echo "No Post";
		return ;	

	}

	$name=$_POST['name'];
	$id=$_POST['id'];
	$email=$_POST['email'];
	$role=$_POST['role'];

	if(mysqli_connect_errno()){
			//echo "Failed to conn.".mysqli_connect_error();
			}
			else{

				//$qq="SELECT * from empl WHERE id='".$id."'";
				
				//$q="INSERT INTO empl(id, Name, email,role) VALUES ('".$id."','".$name."','".$email."','".$role."')";

				$q="INSERT INTO empl(id,Name,email,role) VALUES (?,?,?,?)";

				if($stmt=mysqli_prepare($con,$q)){


					mysqli_stmt_bind_param($stmt,"ssss",$id,$name,$email,$role);

						if (mysqli_stmt_execute($stmt)) {
        						
							echo 1;
    					}
    					else{
    							$error=mysqli_stmt_error($stmt);
    						echo 0;
    					}

    					mysqli_stmt_close($stmt);
				}
				else{
						mysql_error($con);
				}

				mysqli_close($con);

				/*

				if($result=mysqli_query($con,$q)){

					echo 1;
				}
				else{
					echo 0;
				}

				*/

			}

?>