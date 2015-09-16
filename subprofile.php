<?php

	include('connect.php');	

	
	if(!isset($_POST['submit'])){
		//echo "NOPost";
	}
	else{

		$path="res/";
		$allext=array("pdf","doc","docx");


		$role=$_POST['roles'];		//Type of Role
		$fname=$_POST['fname'];		//First Name
		$lname=$_POST['lname'];		//Last Name
		$age=$_POST['age'];			//Age
		$college=$_POST['college']; //College
		$city=$_POST['ccity'];		//City
		$iview=$_POST['empl'];		//Interviewer

		$n=$_POST['iname'];			//New Interviewer
		$i=$_POST['iid'];			//New Interviewer Id
		$e=$_POST['iemail'];		//New Interviewer Email
		$r=$_POST['irole'];			//New Interviewer Role

		$year=$_POST['year'];		//Year of interview
		$month=$_POST['month'];		//Month of Interview
		$date=$_POST['date'];		//Date of Interview
		$hr=$_POST['hr'];			//Hour of Interview
		$minu=$_POST['minu'];		//Minutes of Interview

		$fullname=$_FILES["file"]["name"];		//Resume Path


		$filename="";
		$resok=0;
		$resmsg=0;



		//Resume Check

		$split=explode(".",$fullname);
		$name=$split[0];
		$ext=end($split);		//Taking last segment as extension



		if(   ( $_FILES["file"]["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
				    || $_FILES["file"]["type"]=="application/msword"
				    || $_FILES["file"]["type"]=="application/pdf"
			  )
			  && ($_FILES["file"]["size"]<2000000)
			  && in_array($ext, $allext)
		  )
		  {


				if ($_FILES["file"]["error"]>0)
				{
					$resok=0;
					$resmsg="Error Code: " .$_FILES["file"]["error"]."<br>";
				}
				else{
						//If No File Error

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

			    		   	$resok=1;
			    		   	$resmsg="<span class='holder'>Resume:</span> <span class='value'> <a href='".$path.$finalname."' target='_blank' >".$finalname."</a></span><br>";
			    		   	//echo "Resume: <a href='".$path.$finalname."'>".$finalname."</a><br>";
			    		}
					
					}

			}
			else{
							$resok=0;
							$resmsg="Only .doc .docx .pdf and smaller than 2MB allowed ..!!<br>";
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
		NProgress.start();
	</script>

	<div id="top-bar">	
	</div>

	<div id="header"> Interview Schedule</div><br>
	<div id="can_details">
	<?php

		//Show Details of Interview
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
	
	echo "</div>";		//can_details

		$name=$fname."-".$lname;
		$ppath=$path.$finalname;
		$id=$iview."-".$indate;
	
			
		$q="INSERT INTO interview(id,role,empl,dt,res,name,age,city,coll) VALUES (?,?,?,?,?,?,?,?,?)";
		//echo $q."<br>";
				
		if($stmt=mysqli_prepare($con,$q)){
					

			mysqli_stmt_bind_param($stmt, "ssssssdss",$id,$role,$iview,$indate,$ppath,$name,$age,$city,$college);

				if (mysqli_stmt_execute($stmt)) {
        			
        			//Successfully Written to db
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
								echo "<div class='sche'> <center><h4> Error: ".$error." !</h4><br></center></div>";
								echo "Try Again !";
							}
    					}
				
    					mysqli_stmt_close($stmt);
				}
				else{
					$error=mysqli_error($con);
					echo "<div class='sche'> <center><h4> Error: ".$error." !</h4><br></center></div>";
					echo "Try Again !";
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
			NProgress.done();
</script>
</body>
</html>