<?php
	include('con.php');
?>
<html>
<head>
	<title>Interview Feedback</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript"src="js/jquery.js"></script>
	<script type="text/javascript"src="js/fback.js"></script>
</head>
<body>

	<div id="top-bar">

	</div>
	<div id="header"> Interview Feedback</div>

<div id="fmain">

    <form id="fform" name="fform" action="subf.php"  mehod="POST" enctype="multipart/form-data">
 


	<div id="quest">

		<?php
			
	 		if(mysqli_connect_errno()){
			//echo "Failed to conn.".mysqli_connect_error();
			}
			else{
				
				$lastq=0;
				
				$q=" SELECT qid,quest FROM ques";

				if($result=mysqli_query($con,$q)){
					while($row=mysqli_fetch_assoc($result)){
						//echo "<div id='q".$row['qid']."'>".$row['qid'].".		".$row['quest']." </div>
						//<textarea id='a".$row['qid']."' class='ans'> </textarea><br><br>";


						echo "".$row['quest'].":            
								<select name='q-".$row['qid']."' id='q-".$row['qid']."'>
							  	<option value='1' selected='selected'>1</option>
								<option value='2'>2</option>
								<option value='3'>3</option>
								<option value='4'>4</option>
								<option value='5'>5</option>
							 </select><br><br>";
						$lastq=$row['qid'];
					}
				}

				echo"<input type='number' value='".$lastq."' id='maxq' name='maxq'></input><input type='number' value='0' id='addi' name='addi'></input><br>";
			}
		
	 	?>

	</div>
	<input type="submit" name="submit" id="sub" value="Submit feedback"></input>

	</form>
</div>

</body>
</html>