<?php

	include('connect.php');	

	
	if(!isset($_POST['submit'])){
		echo "NOPost";
	}
	else{

		$path="res/";
		$allext=array("pdf","doc","docx");

		$prevrole=$_POST['crole'];
		$previd=$_POST['previd'];
		$empl=$_POST['empl'];

		//////////////////
		$n=$_POST['iname'];
		$i=$_POST['iid'];
		$r=$_POST['irole'];
		$e=$_POST['iemail'];
		//////////////////

		$y=$_POST['year'];
		$m=$_POST['month'];
		$d=$_POST['date'];
		$h=$_POST['hr'];
		$mi=$_POST['minu'];



		?>


<html>
		<head>
			<title>Interview Schedule</title>
			<link rel="stylesheet" type="text/css" href="css/main.css">
			<link rel="stylesheet" type="text/css" href="css/nprogress.css">
			<script type="text/javascript"src="js/jquery.js"></script>
			<script type="text/javascript"src="js/nprogress.js"></script>
			
		</head>
<body>
	<script >
			//NProgress.start();
	</script>

	<div id="top-bar">

	</div>
	

	<div id="header">
			Interview Schedule
	</div>

	<div id="can_details">

		<?php


		/// Gathering Candidate Details from previous id
		$q="SELECT name,age,city,coll,res FROM `interview` WHERE id=(?)";

				if($stmt=mysqli_prepare($con,$q)){
					

						mysqli_stmt_bind_param($stmt, "s",$previd);


						mysqli_stmt_execute($stmt);

						mysqli_stmt_bind_result($stmt, $name, $age, $city, $coll, $res);


						while (mysqli_stmt_fetch($stmt)) {

							$fn=explode("-",$name);

 							echo "<span class='holder'>Candidate Name :</span> <span class='value'>".$fn[0]."  ".$fn[1]."</span><br>";
 							echo "<span class='holder'>Age :</span> <span class='value'>".$age."</span><br>";
 							echo "<span class='holder'>College :</span> <span class='value'>".$coll."</span><br>";
 							echo "<span class='holder'>City :</span> <span class='value'>".$city."</span><br>";
 							echo "<span class='holder'>Role :</span> <span class='value'>".$prevrole."</span><br>";
 							echo "<span class='holder'>Resume:</span> <span class='value'><a href='".$res."' target='_blank' >Click Here</a></span><br>";
							echo "<span class='holder'>Interviewer :</span> <span class='value'>".$empl."</span><br>";

							$indate=mktime($h,$mi,0,$m,$d,$y);
							//echo $indate."<br>";
							echo "<span class='holder'>Interview to be Held On:</span><span class='value'>".date("d/m/Y",$indate)."</span><br>";
							echo "<span class='holder'>Time:</span> <span class='value'>".date("h:i:s",$indate)."</span><br>";

    					}

        						
    					mysqli_stmt_close($stmt);

    					//echo "No Errrr !";

				}
				else{
					
						$error=mysqli_error($con);
						echo "Prepare Error Getting Candidate Details !<br>";
						echo $error;

				}

		?>

		</div>

		<?php

			$id=$empl."-".$indate;

			
			
				$q="INSERT INTO interview(id,role,empl,dt,res,name,age,city,coll) VALUES (?,?,?,?,?,?,?,?,?)";
				

				//echo $q."<br>";
				
				if($stmt=mysqli_prepare($con,$q)){
					

						mysqli_stmt_bind_param($stmt, "ssssssdss",$id,$prevrole,$empl,$indate,$res,$name,$age,$city,$coll);


						if (mysqli_stmt_execute($stmt)) {
        						
									echo "<div class='sche'> <center><h4> Interview Scheduled !</h4>"."<br>";
									echo "Feedback: <a href='demofback.php?check=".$id."' target='_blank'>Link</a>"."<br><center></div>";

    					}
    					else{
    						$error = mysqli_stmt_error($stmt);

    						//echo "Error :".$error."<br>";
    						$err=explode(" ",$error);
    						$msg=$err[0]." ".$err[1];
    						//echo $msg;
							if($msg=="Duplicate entry"){
								echo "<div class='sche'> <center><h4> Error: Interview already scheuled for interviewer at this time !</h4><br></center></div>";
							}
							else{
								echo "Error: ";
							}
    					}
				
    					mysqli_stmt_close($stmt);
				}
				else{
					$error=mysqli_error($con);
				}
				

				mysqli_close($con);

				/////////////////////

			


	}   //else

	echo "<center><a href='cprofile.php' target='_blank'>Create New Interview</a><br></center>";

?>

<script >
			//NProgress.done();
</script>

</body>
</html>