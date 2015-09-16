<?php
	include('connect.php');

		if(!isset($_POST['submit'])){
		echo "NoPost";
		}
		else{

			$qna=array();
			$maxq=$_POST['maxq'];
			$addi=$_POST['addi'];
			$i_id=$_POST['interview_id'];

			$temp=explode("-", $i_id);
			$new_table=$temp[0].$temp[1];

			for($i=1;$i<=($maxq+$addi);$i++){
				$qna[$i]=$_POST['q-'.$i.''];
			}

			//doenst matter
			$newq=$_POST['newq'];

			$hire="no";
			if(isset($_POST['hire'])){
				$hire=$_POST['hire'];
			}

			$verdict="err";
			if(isset($_POST['verdict'])){
				$verdict=$_POST['verdict'];
			}
			
			

			if($hire=="no" && $verdict=="err"){
				echo "Error: Try Again with Decisions	!!!";
				return;
			 }


	?>

	<!DOCTYPE HTML>

<html>
		<head>
			<title>Feedback Summary</title>
			<link rel="stylesheet" type="text/css" href="css/main.css">
			<link rel="stylesheet" type="text/css" href="css/nprogress.css">
			<script type="text/javascript"src="js/jquery.js"></script>
			<script type="text/javascript"src="js/nprogress.js"></script>
		</head>


<body>
	<script >
			NProgress.start();
	</script>

	<div id="top-bar">	

	</div>

		<div id="header"> Feedback Summary</div><br>
		<div id="can_details">


	<?php



			 //echo "Feedback Summary: <br><br>";

				 ///Candidate Details

			 	$q="SELECT name,age,city,coll,role,dt FROM `interview` WHERE id=(?)";

				if($stmt=mysqli_prepare($con,$q)){
					

						mysqli_stmt_bind_param($stmt, "s",$i_id);


						mysqli_stmt_execute($stmt);

						mysqli_stmt_bind_result($stmt, $name, $age, $city, $coll, $role, $dt);


						while (mysqli_stmt_fetch($stmt)) {

							$fn=explode("-",$name);

 							echo "<span class='holder'>Candidate Name : </span> <span class='value'>".$fn[0]."  ".$fn[1]."</span><br>";
 							echo "<span class='holder'>Age : </span> <span class='value'>".$age."</span><br>";
 							echo "<span class='holder'>College :</span> <span class='value'>".$coll."</span><br>";
 							echo "<span class='holder'>City : </span> <span class='value'>".$city."</span><br>";
 							echo "<span class='holder'>For Profile: </span> <span class='value'>".$role."</span><br>";
 							echo "<span class='holder'>Interview Held on: </span> <span class='value'>".date("d/m/Y",$dt)."</span><br>";
							echo "<span class='holder'>Time: </span> <span class='value'>".date("h:i:s",$dt)."</span><br>";
							echo "<span class='holder'>Interviewer: </span> <span class='value'>".$temp[0]."</span><br>";

    					}

        						
    					mysqli_stmt_close($stmt);
    					

				}
				else{
					
						$error=mysqli_error($con);
						echo "<span class='holder'>Error Getting Candidate Details !</span><br>";
						echo $error;

				}

	?>
	</div>
	
	<?php

			 /*
				 $q="SELECT name,age,city,coll,role,dt FROM `interview` WHERE id='".$i_id."'";

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


			 //////////Inserting answers to default questions
				
			/*	
			for($i=1;$i<=$maxq;$i++){

			$q = "UPDATE interview SET q(?)=(?) WHERE id=(?) ";

				
				if($stmt=mysqli_prepare($con,$q)){


					mysqli_stmt_bind_param($stmt, "dss",$i,$qna[$i],$i_id);

						if(mysqli_stmt_execute($stmt)){

								}
						else{
								$error = mysqli_stmt_error($stmt);
								//Error Updating Answers
								echo "Error While Saving Answers Try Again !";
						}

						mysqli_stmt_close($stmt);
				}
				else{
						$error=mysqli_error($con);
						mysqli_close($con);
				}
			}
			*/
			
			
				///////Saving Responses to Questions
				for($i=1;$i<=$maxq;$i++){
					$query="UPDATE `interview` SET `q".$i."`=".$qna[$i]." WHERE id='".$i_id."'";
					//echo $query."<br>";

					if($result=mysqli_query($con,$query)){

					}
					else{
						echo "<div class='sche'><center>Error while saving answers !</center</div>";
							return 0;
					}
				}

			
				//////////Update number of additional Questions
				/*
				$query="UPDATE `interview` SET `addi`=".$addi." WHERE id='".$i_id."'";
				//echo $query."<br>";

				if($result=mysqli_query($con,$query)){

				}
				else{
					echo "Error while saving answers !";	
				}
				*/
				$q = "UPDATE interview SET addi=(?) WHERE id=(?) ";
				
				
				if($stmt=mysqli_prepare($con,$q)){


					mysqli_stmt_bind_param($stmt, "ds",$addi,$i_id);

						if(mysqli_stmt_execute($stmt)){

								}
						else{
								$error = mysqli_stmt_error($stmt);
								//Error Updating Answers
								echo "Error While Saving Addi Try Again !";
						}

						mysqli_stmt_close($stmt);
				}
				else{
						$error=mysqli_error($con);
						mysqli_close($con);

						echo "<div class='sche'><center>Error while saving responses !</center></div>";
						return 0;
				}


				

				////////Updating additional Question's Answer

				for($i=1;$i<=$addi;$i++){

					$query="UPDATE `".$new_table."` SET `ans`=".$qna[($i+$maxq)]." WHERE id='".$i."'";
						//echo $query."<br>";

					if($result=mysqli_query($con,$query)){

					}
					else{
							//$error=mysqli_error($con);
							echo "<div class='sche'><center>Error while saving addi answers !</center></div>";
							return 0;	
					}
				}






			echo "<br><div class='sche'><center>Performance Details: </center></div><br>";


	?>

	<div class="ans_table">

	<?php
			////////////Display Answers

			//$q=" SELECT qid,quest FROM ques";
			$i=1;
			$q="SELECT quest FROM `ques` ORDER BY qid ASC";

				if($result=mysqli_query($con,$q)){
					while($row=mysqli_fetch_assoc($result)){
						

						echo "<span class='holder'> ".$row['quest']."</span>   : <span class='value'>  ".$qna[$i]."</span><br>";
						$i++;
					}
				}







				//...

			//If there are additional questions
			if($addi!=0){

			//echo"<br> Additional Questions: ".$addi."<br><br>";


			//Displaying Additional-Question's Answer
			$i=1;
			$q="SELECT ques FROM `".$new_table."` order by id asc limit ".$addi."";
			if($result=mysqli_query($con,$q)){

					while($row=mysqli_fetch_assoc($result)){
						

						echo "<span class='holder'> ".$row['ques']."</span>   : <span class='value'>   ".$qna[($i+$maxq)]."</span><br>";
						$i++;
					}
				}
				else{
					echo "<div class='sche'><center>Error: Fetching Answers !</center></div>";
				}

			}	///$addi!=0


	?>

	</div>

	<?php


			//Further Candidature

			if($hire!="no"){
				

					$q = "UPDATE interview SET hire=1, next=0, reject=0 WHERE id=(?) ";
				
				
					if($stmt=mysqli_prepare($con,$q)){


						mysqli_stmt_bind_param($stmt, "s",$i_id);

							if(mysqli_stmt_execute($stmt)){
										echo "<br><div class='sche'><center>Verdict: Hire !</center></div>";
									}
							else{
									$error = mysqli_stmt_error($stmt);
									//Error Updating Answers
									echo "<div class='sche'><center>Couldn't save response try again ! </center></div>";
									return 0;
							}

							mysqli_stmt_close($stmt);
					}
					else{
							$error=mysqli_error($con);
							mysqli_close($con);

							echo "<div class='sche'><center>Error Prepare: ".$error."<br>Try Again!</center></div>";
							return 0;
					}





				/*
				$query="UPDATE `interview` SET `hire`=1 WHERE id='".$i_id."'";
				//echo $query."<br>";

				if($result=mysqli_query($con,$query)){
					echo "<br> Verdict: Hired!";
				}
				else{
					echo "Error while saving answers !";	
				}
				*/

			} //$hire
			else{

				if($verdict=="nextr"){

					//making changes for next round
					$q = "UPDATE interview SET next=1, hire=0, reject=0 WHERE id=(?) ";
				
				
					if($stmt=mysqli_prepare($con,$q)){


						mysqli_stmt_bind_param($stmt, "s",$i_id);

							if(mysqli_stmt_execute($stmt)){
										echo "<br><div class='sche'><center>Verdict: Next Round </center></div>";
									}
							else{
									$error = mysqli_stmt_error($stmt);
									//Error Updating Answers
									echo "<div class='sche'><center>Couldn't save response try again ! </center></div>";
									return 0;
							}

							mysqli_stmt_close($stmt);
					}
					else{
							$error=mysqli_error($con);
							mysqli_close($con);

							echo "<div class='sche'><center>Error Prepare: ".$error."<br>Try Again!</center></div>";
							return 0;
					}


					/*
					$query="UPDATE `interview` SET `next`=1 WHERE id='".$i_id."'";
					if($result=mysqli_query($con,$query)){
							echo "<br>Verdict: Qualified For Next Round ( ".$verdict.")";
						}
					else{
					echo "Error while saving answers !";	
					}
					*/

				}	
				else{

					// changes for rejecting

					$q = "UPDATE interview SET reject=1, hire=0, next=0 WHERE id=(?) ";
				
				
					if($stmt=mysqli_prepare($con,$q)){


						mysqli_stmt_bind_param($stmt, "s",$i_id);

							if(mysqli_stmt_execute($stmt)){
										echo "<br><div class='sche'><center>Verdict: Rejected </center></div>";
									}
							else{
									$error = mysqli_stmt_error($stmt);
									//Error Updating Answers
									echo "<div class='sche'><center>Couldn't save response try again ! </center></div>";
									return 0;
							}

							mysqli_stmt_close($stmt);
					}
					else{
							$error=mysqli_error($con);
							mysqli_close($con);

							echo "<div class='sche'><center>Error Prepare: ".$error."<br>Try Again!</center></div>";
							return 0;
					}




					/*
					$query="UPDATE `interview` SET `reject`=1 WHERE id='".$i_id."'";
					if($result=mysqli_query($con,$query)){
							echo "<br>Verdict: Rejected ( ".$verdict.")";
						}
					else{
					echo "Error while saving answers !";	
					}
					*/

				}

			}// not hired

		}

		echo "<br><center> Notify Link: <a href='nxtschedule.php?schid=".$i_id."' target='_blank'>Link</a>"."</center><br>";
?>

<script >
			NProgress.done();
	</script>
</body>
</html>