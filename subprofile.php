<?php

	include('connect.php');	

	
	if(!isset($_POST['submit'])){
		echo "NOPost";
	}
	else{

		$path="res/";
		$allext=array("pdf","doc","docx");


		$role=$_POST['roles'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$age=$_POST['age'];
		$college=$_POST['college'];
		$city=$_POST['ccity'];
		$iview=$_POST['empl'];
		$n=$_POST['iname'];
		$i=$_POST['iid'];
		$e=$_POST['iemail'];
		$r=$_POST['irole'];

		$year=$_POST['year'];
		$month=$_POST['month'];
		$date=$_POST['date'];
		$hr=$_POST['hr'];
		$minu=$_POST['minu'];

		$fullname=$_FILES["file"]["name"];

		$email="no";
		if(isset($_POST['smail'])){
			$email=$_POST['smail'];
		}

		$filename="";
		$resok=0;
		$resmsg=0;



		//Resume Check

			$split=explode(".",$fullname);

			$name=$split[0];
			//$ext=$split[1];
			$ext=end($split);

			//echo $fullname."<br>";

			//echo $name." . ".$ext."<br>";


				if(   ( $_FILES["file"]["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
				        || $_FILES["file"]["type"]=="application/msword"
				        || $_FILES["file"]["type"]=="application/pdf"
				      )
					   && ($_FILES["file"]["size"]<2000000)
					   && in_array($ext, $allext)
				   ){


				   		if ($_FILES["file"]["error"]>0)
						{
					   		//echo "Error Code: " .$_FILES["file"]["error"]."<br>";

					   		$resok=0;
					   		$resmsg="Error Code: " .$_FILES["file"]["error"]."<br>";
					   		//return ;
						}
						else{

									$finalname=$name.".".$ext;
								if(file_exists($path.$finalname))
			    				{ 
			    		 			//" already Exists"
			    		 			$ranval=mt_rand(1,10000);
			    		 			$finalname=$name."-".$ranval.".".$ext;

			    		 			move_uploaded_file($_FILES["file"]["tmp_name"], $path.$finalname);
			    		 			//echo $finalname." Uploaded.. <br>";
			    		 			$resok=1;
			    		 			$resmsg="<span class='holder'>Resume:</span> <span class='value'><a href='".$path.$finalname."' target='_blank' >".$finalname."</a></span><br>";

			    		 			//echo "Resume: <a href='".$path.$finalname."'>".$finalname."</a><br>";
			    				}
			    				else
			    		  		{
			    		   			move_uploaded_file($_FILES["file"]["tmp_name"],$path.$finalname);
			    		   			//echo $finalname." uploaded...<br>";

			    		   			$resok=1;
			    		   			$resmsg="<span class='holder'>Resume:</span> <span class='value'> <a href='".$path.$finalname."' target='_blank' >".$finalname."</a></span><br>";
			    		   			//echo "Resume: <a href='".$path.$finalname."'>".$finalname."</a><br>";
			    		   		}
						}

					}
					else{


							echo "Only .doc .docx .pdf and smaller than 2MB allowed ..!!<br>";
							$resok=0;
							//return;
					}

		if($resok==0){
			echo $resmsg;
			return ;
		}
	?>

	<!DOCTYPE HTML>

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

		<div id="header"> Interview Schedule</div><br>
		<div id="can_details">
	<?php

		//echo "Send Email?? :".$email."<br>";

		//Show Details
	    echo "<span class='holder'>Candidate Name :</span> <span class='value'>".$fname." ".$lname."</span><br>";
		echo "<span class='holder'>Role :</span> <span class='value'>".$role."</span><br>";
		echo "<span class='holder'>Age :</span> <span class='value'>".$age."</span><br>";
		echo "<span class='holder'>College :</span> <span class='value'>".$college."</span><br>";
		echo "<span class='holder'>City :</span> <span class='value'>".$city."</span><br>";
		echo "<span class='holder'>Interviewer :</span> <span class='value'>".$iview."</span><br>";

		echo $resmsg;

		///hr,min,sec,month,day,year
		$indate=mktime($hr,$minu,0,$month,$date,$year);
		//echo $indate."<br>";
		echo "<span class='holder'>Interview to be Scheduled On:</span> ".date("d/m/Y",$indate)."</span><br>";
		echo "<span class='holder'>Time:</span> ".date("h:i:s",$indate)."</span><br>";
	?>
	</div>
	<?php
		

		$name=$fname."-".$lname;

		$ppath=$path.$finalname;

		$id=$iview."-".$indate;

			
			
				$q="INSERT INTO interview(id,role,empl,dt,res,name,age,city,coll) VALUES (?,?,?,?,?,?,?,?,?)";
				

				//echo $q."<br>";
				
				if($stmt=mysqli_prepare($con,$q)){
					

						mysqli_stmt_bind_param($stmt, "ssssssdss",$id,$role,$iview,$indate,$ppath,$name,$age,$city,$college);


						if (mysqli_stmt_execute($stmt)) {
        						
									echo "<div class='sche'> <center><h4> Interview Scheduled !</h4>"."<br>";
									//echo "Feedback: <a href='fback.php?check=".$id."' target='_blank'>Link</a>"."<br><center></div>";
									echo "Feedback: <a href='demofback.php?check=".$id."' target='_blank'>Link</a>"."<br><center></div>";

    					}
    					else{
    						$error = mysqli_stmt_error($stmt);

    						//echo "Error :".$error."<br>";
    						$err=explode(" ",$error);
    						$msg=$err[0]." ".$err[1];
    						//echo $msg;
							if($msg=="Duplicate entry"){
									echo "<div class='sche'> <center><h4> Error: Interview already scheuled with interviewer at this time !</h4><br></center></div>";
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
				
			/*
			$q="INSERT INTO interview(id,role,empl,dt,res,name,age,city,coll) VALUES ('".$id."','".$role."','".$iview."','".$indate."','".$path.$finalname."','".$name."','".$age."','".$city."','".$college."')";
				if($result=mysqli_query($con,$q)){

					echo "Interview Scheduled !"."<br>";
					echo "Feedback: <a href='fback.php?check=".$id."' target='_blank'>Link</a>"."<br>";

				}
				else{
					
					$err=explode(" ",mysqli_error($con));

					$msg=$err[0]." ".$err[1];

					if($msg=="Duplicate entry"){
						echo "Interview for interviewer at that time is already Scheduled !<br>";
					}

					echo "Try again !<br>";
				}
			
			*/
			


	}   //else

	echo "<center><a href='cprofile.php' target='_blank'>Create New Interview</a><br></center>";

?>

<script >
			//NProgress.done();
	</script>
</body>
</html>