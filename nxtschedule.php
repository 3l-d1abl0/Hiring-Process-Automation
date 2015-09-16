<?php

	include('connect.php');

?>
<html>

<head>
			<title>Interview Results</title>
			<link rel="stylesheet" type="text/css" href="css/main.css">
			<link rel="stylesheet" type="text/css" href="css/nprogress.css">
			<script type="text/javascript"src="js/jquery.js"></script>
			<script type="text/javascript"src="js/nxtschedule.js"></script>
			<script type="text/javascript"src="js/nprogress.js"></script>
</head>
<body>
	<script >
			NProgress.start();
	</script>

	<div id="top-bar">
	</div>

	<div id="header">
			Interview Results
	</div>

	<?php

		if(!isset($_GET['schid'])){
			echo "Err...!";	return 0;
		}

		$schid=$_GET['schid'];
		$del="-";

		$details=explode($del,$schid);


		//Check if its a valid Interview id.
		
		$qq="SELECT count(*) FROM `interview` WHERE id=(?)";
		if($st=mysqli_prepare($con,$qq)){

			mysqli_stmt_bind_param($st,"s",$schid);

			mysqli_stmt_execute($st);

			mysqli_stmt_bind_result($st,$count);

			while(mysqli_stmt_fetch($st)){

					if($count==0){
						echo "<div class='sche'><center>No Such Interview Found !</center></div>";
						mysqli_stmt_close($st);
						return 0;
					}
			}
		}
		else{
				$error=mysqli_error($con);
				echo "Prepare Error While checking interview id !<br>";
				echo $error;
				return 0;

		}

		?>

		<div id="can_details">

		<?php


		$hire=0;	$next=0; $next=0;
		///Candidate Details
		$q="SELECT name,age,city,coll,role,res,addi,hire,next,reject,eval FROM `interview` WHERE id=(?)";

				if($stmt=mysqli_prepare($con,$q)){
					

						mysqli_stmt_bind_param($stmt, "s",$schid);


						mysqli_stmt_execute($stmt);

						mysqli_stmt_bind_result($stmt, $name, $age, $city, $coll, $role, $res,$addi,$hire,$next,$reject,$eval);


						while (mysqli_stmt_fetch($stmt)) {

							$fn=explode("-",$name);

 							echo "<span class='holder'>Candidate Name : </span> <span class='value'>".$fn[0]."  ".$fn[1]."</span><br>";
 							echo "<span class='holder'>Age : </span> <span class='value'>".$age."</span><br>";
 							echo "<span class='holder'>College :</span> <span class='value'>".$coll."</span><br>";
 							echo "<span class='holder'>City : </span> <span class='value'>".$city."</span><br>";
 							echo "<span class='holder'>For Profile: </span> <span class='value'>".$role."</span><br>";
 							echo "<span class='holder'>Resume: </span> <span class='value'><a href='".$res."' target='_blank'>Click Here</a></span><br>";
 							echo "<span class='holder'>Interview Held on: </span> <span class='value'>".date("d/m/Y",$details[1])."</span><br>";
							echo "<span class='holder'>Time: </span> <span class='value'>".date("h:i:s",$details[1])."</span><br>";

							echo "<span class='holder'>Interviewer: </span> <span class='value'>".$details[0]."</span><br>";

    					}

        						
    					mysqli_stmt_close($stmt);

    					//echo "No Errrr !";
    					if($eval==0){
    						echo "<br><br><div class='sche'>This profile is yet to be Evaluated !</div>";

    						?>
    					<script >
							NProgress.done();
						</script>

    						<?php
    						return 0;
    					}

				}
				else{
					
						$error=mysqli_error($con);
						echo "Prepare Error Getting Candidate Details !<br>";
						echo $error;

				}

			
		?>

	</div>

		<?php

				////////////

		//gathering number of default questions

		$q=" SELECT COUNT(*) FROM ques ";
		//echo $q;
		if($result=mysqli_query($con,$q)){

			$defqnum=mysqli_fetch_row($result);

			//print_r($defqnum);
						
		}	
		else{
					echo "Error: Fetching Interview Feedback !";
			}


			/////gatehering default question response

			$q="SELECT ";
			for($i=1;$i<$defqnum[0];$i++){

				$q.="q".$i.",";
			}

			$q.="q".$defqnum[0]." FROM interview where id='".$schid."'";

			//echo $q;

			if($result=mysqli_query($con,$q)){

					$default_ans=mysqli_fetch_row($result);
						
				}
				else{
					echo "Error: Fetching Default Answers Response !";
				}


				echo "<br><div class='sche'><center> Interview Summary :</center></div><br>";

		?>


			<!--	Presenting Answers	-->
			<div class="ans_table">

		<?php	
			//gathering default questions



				$q=" SELECT quest FROM ques ORDER BY qid";

				$idx=0;
				if($result=mysqli_query($con,$q)){

					while($default_ques=mysqli_fetch_row($result)){
						//echo "<span class='holder'> ".$default_ques[0]." : </span><span class='value'> ".$default_ans[$idx]."</span><br>";
						
						echo "<br><span class='holder'> ".$default_ques[0]."</span> : <br> ";
						for($j=1;$j<=$default_ans[$idx];$j++){
							echo "<div class='default_stars new_marks' ></div>";
						}
						echo"<br>";

						$idx++;
					}
				}
				else{
					echo "Error: Fetching Default questions.. !";
						return 0;
				}

				///gathering additional question response

				

				if($addi!=0){

				//echo "Additional Ques: ".$addi."<br>";
				//echo "Additional: <br>";
				  echo "<br>";

						$q="SELECT id, ques, ans FROM ".$details[0].$details[1]." LIMIT ".$addi."";

						if($result=mysqli_query($con,$q)){

							while($addi_ques=mysqli_fetch_assoc($result)){
								//echo "<span class='holder'>".$addi_ques['ques']."  :</span> <span class='value'>".$addi_ques['ans']."</span><br>";
							
								echo "<br><span class='holder'> ".$addi_ques['ques']."</span> : <br> ";
										for($j=1;$j<=$addi_ques['ans'];$j++){
											echo "<div class='default_stars new_marks' ></div>";
										}
										echo"<br>";

							}
						}
						else{
							echo "Error: fetching additional question responses.. !<br>";
							return 0;
						}

				}	//if no additional ques

			?>
		</div>
			<?php

		if($hire==1){
					echo "<div class='sche'><center><h4>Hire !</h4></center></div><br>";
		}
		else{

			if($reject==1){

				echo "<div class='sche'><center><h4>Reject !</h4></center></div><br>";


			}
			else{

					///Schedule next Round

				echo "<div class='sche'><center><h4>Schedule Next Interview :</h4></center></div><br>";


				//echo "<label id='currid'>".$role."</label>";
		?>

			<!-- for scheduling next round -->

	<div id="main">
	<form id="cform" name="cform" action="nxtcnfrm.php" method="POST" enctype="multipart/form-data">
		

	 <?php echo "<input type='text' name='crole' id='crole' class='invisible' value='".$role."'></input><input type='text' name='previd' class='invisible' value='".$schid."'></input><br>"; ?>
	 Interviewer: <select name="empl" id="empl" required>
	 	<?php
	 		if(mysqli_connect_errno()){
			//echo "Failed to conn.".mysqli_connect_error();
			}
			else{
				
				$q=" SELECT id,name FROM empl WHERE role='".$role."'";

				if($result=mysqli_query($con,$q)){
					while($row=mysqli_fetch_assoc($result)){
						echo "<option value=".$row['id'].">".$row['name']."</option>";
					}
				}
			}

	 	?>
	 	</select><br><br>

	 <input type="button" name="addi" value="add interviewers" id="adbtn"></input>
	 

	 
	 <!--//interviewer adding box -->

	 <div id="addin">
	 	<br>
	 	Name: <input type="text" name="iname" id="iname" placeholder="Interviewer Name"></input> &nbsp; &nbsp; &nbsp; ID: <input type="text" name="iid" id="iid" placeholder="id"></input><br><br>
	 	Role :<input type="text" name="irole" id="irole" placeholder="Role"></input>&nbsp; &nbsp; &nbsp;  Email: <input type="email" name="iemail" id="iemail" placeholder="email"></input><br>	
	 	
	 	<div id="adderrr">rtrt</div>
	 	<br>
	 	<input type="button" name="add" value="ADD" id="add"></input><br><br>
	 	
	 	<input type="button" name="done" value="DONE" id="done"> </input>	 	
	 </div>
	 <br><br>




	 Set Interiew Time: <br>
	 Year: <input type="number" name="year" id="year" min="<?php echo date("Y") ?>" placeholder="Year" required>
	 Month:<select name="month" id="month" required>
	 	<?php 
	 		for($i=1;$i<=12;$i++){
	 			echo"<option value=".$i.">".$i."</option>";
	 		} 

	 	?>
	 </select>
	 Date: <select name="date" id="date" required>
	 	<?php 
	 		for($i=1;$i<=31;$i++){
	 			echo"<option value=".$i.">".$i."</option>";
	 		}

		?>

	 </select><br><br>
	 H: <input type="number" name="hr" id="hr" min="0" max="23" placeholder="Hours" required></input>
	 Min: <input type="number" name="minu" id="minu" min="0" max="59" placeholder="Minutes" required></input>
	 <!--<input type="button" id="addres" value="Resume"><br><br> -->
	 <br><br>
	 <!--
	 Resume: <input type="file" name="file" required><br>
		-->

	 <!--
	 Send Email ? : <input type="checkbox" value="yes" name="smail" >
		-->
	 <div class="errr" id="errr">
	 	Error Box!
	 </div>

	 <br><br>
	 <input type="submit" name="submit" id="submit" value="CREATE"></input>
	</form>
	</div>









		<?php





			}	//next round





		}	//$hire


	?>

<script >
			NProgress.done();
</script>

</body>
</html>