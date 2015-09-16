<?php

include('connect.php');

?>

<!DOCTYPE HTML>

<html>
<head>
	<title>Create an Interview</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/nprogress.css">
	<script type="text/javascript"src="js/jquery.js"></script>
	<script type="text/javascript"src="js/jscript.js"></script>
	<script type="text/javascript"src="js/nprogress.js"></script>
</head>


<body>
	<script >
			NProgress.start();
	</script>

	<div id="top-bar">	</div>
	<div id="header">Create An Interview</div><br>

	<div id="main">

	<!-- Form Section	-->

	<form id="cform" name="cform" id="cform" action="subprofile.php" method="POST" enctype="multipart/form-data">
		Choose a Role:      &nbsp; <select name="roles" id="roles" required>
										<option value="sales" selected="selected">Sales</option>
										<option value="tech">Tech</option>
									</select>
									<br><br>

	 First Name: &nbsp;
	 <input type="text" name="fname" id="fname" placeholder="First Name" required></input> &nbsp;&nbsp;&nbsp;
	 
	 Last Name: &nbsp;
	 <input type="text" name="lname" id="lname" placeholder="Last Name" required></input><br><br>
	 
	 Age: &nbsp;<input type="number" name="age" id="age" placeholder="Age" required></input><br><br>
	 
	 College: &nbsp;<input type="text" name="college" id="college" placeholder="College Name" required></input><br><br>
	 
	 Current city: &nbsp;<input type="text" name="ccity" id="ccity" Placeholder="Current City" required></input><br><br>
		
	  <!-- Date : <input type="datetime-local" name="idate" required/><br> -->
	 
	 Interviewer: &nbsp;&nbsp;
	 	<select name="empl" id="empl" required>
	 		<?php
			
				$q=" SELECT id,name FROM empl WHERE role='sales'";

				if($result=mysqli_query($con,$q)){
					while($row=mysqli_fetch_assoc($result)){
						echo "<option value=".$row['id'].">".$row['name']."</option>";
					}
				}

	 		?>
	 	</select><br><br>

	 <input type="button" name="addi" value="add interviewers" id="adbtn"></input>
	 
	 	  <!-- Interviewer Adding Section	-->
	 <div id="addin">
	 	<br>
	 	Name: &nbsp;<input type="text" name="iname" id="iname" placeholder="Interviewer Name"></input> &nbsp; &nbsp; &nbsp; ID: &nbsp;<input type="text" name="iid" id="iid" placeholder="id"></input><br><br>
	 	Role: &nbsp;<input type="text" name="irole" id="irole" placeholder="Role"></input>&nbsp; &nbsp; &nbsp;  Email: &nbsp;<input type="email" name="iemail" id="iemail" placeholder="email"></input><br>	
	 	
	 	<div id="adderrr">rtrt</div>
	 	<br>
	 	<input type="button" name="add" value="ADD" id="add"></input><br><br>
	 	
	 	<input type="button" name="done" value="DONE" id="done"> </input>	

	 </div>
	 	 <!-- Interviewer Adding Section Ends	-->
	 <br><br>

	 Set Interiew Time: <br>
	 Year: <input type="number" name="year" id="year"  min="<?php echo date("Y") ?>" placeholder="Year" required>
	 Month:
	 <select name="month" id="month" required>
	 	<?php 
	 		for($i=1;$i<=12;$i++){
	 			echo"<option value=".$i.">".$i."</option>";
	 		} 

	 	?>
	 </select>
	 Date:
	 <select name="date" id="date" required>
	 	<?php 
	 		for($i=1;$i<=31;$i++){
	 			echo"<option value=".$i.">".$i."</option>";
	 		}

		?>
	 </select><br><br>
	 Hour: <input type="number" name="hr" id="hr" min="0" max="23" placeholder="Hours" required></input>
	 Min: <input type="number" name="minu" id="minu" min="0" max="59" placeholder="Minutes" required></input>
	 <br><br>
	 Resume: <input type="file" name="file" required><br>

	 <div class="errr" id="errr">
	 	Error Box!
	 </div>

	 <br><br>
	 <input type="submit" name="submit" id="submit" value="CREATE" style="width:150px; height:30px;"></input>
	</form>
	</div>	
	<script >
			NProgress.done();
	</script>
</body>
</html>