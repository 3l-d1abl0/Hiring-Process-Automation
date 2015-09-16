<?php
	include('connect.php');
?>
<html>
		<head>
			<title>Interview Feedback</title>
			<link rel="stylesheet" type="text/css" href="css/main.css">
			<link rel="stylesheet" type="text/css" href="css/nprogress.css">
			<script type="text/javascript"src="js/jquery.js"></script>
			<script type="text/javascript"src="js/demofback.js"></script>
			<script type="text/javascript"src="js/nprogress.js"></script>
		</head>
<body>
	<script >
			NProgress.start();
	</script>
	<div id="top-bar">
	</div>
	

	<div id="header">
			Interview Feedback
	</div>

	

	
	<?php

		if(!isset($_GET['check'])){
				echo "<div class='sche'> <center><h4> Wrong Request !</h4><br></center></div>";
				echo "<script>NProgress.done(); </script>";
				return 0;
		}

		$inter_id=$_GET['check'];
		//echo $inter_id."<br>";
		$del="-";

		$details=explode($del,$inter_id);



		//Check if its a valid Interview id.
		
		$qq="SELECT count(*) FROM interview WHERE id=(?)";
		if($st=mysqli_prepare($con,$qq)){

			mysqli_stmt_bind_param($st,"s",$inter_id);

			mysqli_stmt_execute($st);

			mysqli_stmt_bind_result($st,$count);

			while(mysqli_stmt_fetch($st)){

					if($count==0){
						echo "<div class='sche'> <center><h4> That interview Does not Exists !</h4><br></center></div>";
						echo "<script>NProgress.done(); </script>";
						mysqli_stmt_close($st);
						return 0;
					}
			}
		}
		else{
				$error=mysqli_error($con);
				echo "<div class='sche'> <center><h4> Prepare Error While checking interview id !</h4><br></center></div>";
				echo $error;
				echo "<script>NProgress.done(); </script>";
				return 0;

		}
		
	?>

	<div id="detail">
	<?php
		//echo "Interiew Details: <br>";
		//echo $inter_id;


		///Candidate Details
		$q="SELECT name,age,city,coll,role,dt,res,eval FROM interview WHERE id=(?)";

			if($stmt=mysqli_prepare($con,$q)){
					
					mysqli_stmt_bind_param($stmt, "s",$inter_id);

					mysqli_stmt_execute($stmt);

					mysqli_stmt_bind_result($stmt, $name, $age, $city, $coll, $role, $dt,$res,$eval);

					while (mysqli_stmt_fetch($stmt)) {

						$fn=explode("-",$name);

 						echo "<span class='holder'>Candidate Name : </span> <span class='value'>".$fn[0]."  ".$fn[1]."</span><br>";
 						echo "<span class='holder'>Age : </span> <span class='value'>".$age."</span><br>";
 						echo "<span class='holder'>College : </span> <span class='value'>".$coll."</span><br>";
 						echo "<span class='holder'>City : </span> <span class='value'>".$city."</span><br>";
 						echo "<span class='holder'>For Profile: </span> <span class='value'>".$role."</span><br>";
 						echo "<span class='holder'>Resume</span> <span class='value'><a href='".$res."' target='_blank' >Click Here</a></span><br>";
 						echo "<span class='holder'>Interview held on: </span><span class='value'>".date("d/m/Y",$dt)."</span><br>";
						echo "<span class='holder'>Time: </span><span class='value'>".date("h:i:s",$dt)."</span><br>";
						echo "<span class='holder'>Interviewer: </span><span class='value'>".$details[0]."</span>";
    				}

        			mysqli_stmt_close($stmt);


    				if($eval!=0){
    						echo "<br><br><div class='sche'>This profile has been Evaluated !</div>";
    						echo "<script >	NProgress.done(); </script>";
							return 0;
    				}

    					//echo "No Errrr !";

			}
			else{
					
						$error=mysqli_error($con);
						echo "<br><br><div class='sche'> Prepare Error Getting Candidate Details !</div><br>";
						echo $error;
						echo "<script >	NProgress.done(); </script>";
						return 0;

			}


				/*

				$q="SELECT name,age,city,coll,role,dt FROM `interview` WHERE id='".$inter_id."'";

						if($result=mysqli_query($con,$q)){
							while($row=mysqli_fetch_assoc($result)){
									$fn=explode("-",$row['name']);

		 							echo "Candidate Name : ".$fn[0]."  ".$fn[1]."<br>";
		 							echo "Age : ".$row['age']."<br>";
		 							echo "College : ".$row['coll']."<br>";
		 							echo "City : ".$row['city']."<br>";
		 							echo "For Profile: ".$row['role']."<br>";
		 							echo "Interview Date: ".date("d/m/Y",$row['dt'])."<br>";
									echo "Time: ".date("h:i:s",$row['dt'])."<br>";
							}
						}
						else{

							//error fetching candidate details

						}
				*/

	?>
	</div>


<div id="fmain">
			
			<div class='sche'>Answer the following Question on a scale of 1-5:</div>
    
			<!-- Feedback form -->
    <form id="fform" name="fform" action="subf.php"  method="POST">

			<div id="quest" class="quest">

			<?php

						
						$lastq=0;	$qq="";	$kk="";

						$q=" SELECT qid,quest FROM ques";

						if($result=mysqli_query($con,$q)){

							while($row=mysqli_fetch_assoc($result)){
								
								$qq.="".$row['quest'].":            
										<select name='q-".$row['qid']."' id='q-".$row['qid']."'>
									  		<option value='1' selected='selected'>1</option>
											<option value='2'>2</option>
											<option value='3'>3</option>
											<option value='4'>4</option>
											<option value='5'>5</option>
									 	</select><br><br>";

								$kk.="".$row['quest'].":  
										<div class='rate-ex1-cnt' id='q_".$row['qid']."'>
									    <div class='star_1 ratings_stars' id='1'></div>
									    <div class='star_2 ratings_stars' id='2'></div>
									    <div class='star_3 ratings_stars' id='3'></div>
									    <div class='star_4 ratings_stars' id='4'></div>
									    <div class='star_5 ratings_stars' id='5'></div>
									    <span class='invisible'>0</span>
									    <input type='number' name='q-".$row['qid']."' id='q-".$row['qid']."' value='0' class='invisible'></input>
											</div><br>";
									 	
								$lastq=$row['qid'];
							}
						}

						echo"<input type='number' value='".$lastq."' id='maxq' class='invisible' name='maxq'></input><input type='number' value='0' id='addi' class='invisible' name='addi'></input>
							 <input type='text' value='".$inter_id."' id='interview_id' class='invisible' name='interview_id'></input><br>";

						//echo $qq;
						echo $kk;


			 ?>

			</div>

			<input type="button" id="addqb" name="addqb" value="Add More Questions"></input>

			<div id="newqerr">
			</div>

			<div id="addquestion">
				Type in your Question:<br>
				<textarea id="newq" row="10" col="3" name="newq"> </textarea><br><br>
				
				<input type="button" id="addit" name="addit" value="Add It !"></input><br><br>
				<input type="button" id="doneadd" name="doneadd" value="Done Adding"></input>
			</div>


			<br><br>
			
			<div id="hbox">
				Hire: 
				<input type="checkbox" name="hire" value="hire" id="hire" checked> </input>
			</div>
			

			<br>

			<div id="nxtround">

				<input type="radio" name="verdict" value="reject" required checked="checked">Reject</input><br>
				<input type="radio" name="verdict" value="nextr" required>Next Round</input>

			</div>

			<br><br>
			<input type="submit" name="submit" value="Submit" id="sub"></input>

	</form>
</div>


<script >
			NProgress.done();
</script>

</body>
</html>