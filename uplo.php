<?php
	
	$path="res/";
	$fullname=$_FILES["file"]["name"];

	$allext=array("pdf","doc","docx");

	$split=explode(".",$fullname);

	$name=$split[0];
	//$ext=$split[1];
	$ext=end($split);

	echo $fullname."<br>";

	echo $name." . ".$ext."<br>";


	if(   ( $_FILES["file"]["type"]=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
	        || $_FILES["file"]["type"]=="application/msword"
	        || $_FILES["file"]["type"]=="application/pdf"
	      )
		   && ($_FILES["file"]["size"]<2000000)
		   && in_array($ext, $allext)
	   ){


	   		if ($_FILES["file"]["error"]>0)
			{
		   		echo "Error Code: " .$_FILES["file"]["error"]."<br>";
			}
			else{

						$finalname=$name.".".$ext;
					if(file_exists($path.$finalname))
    				{ 
    		 			//echo $photo." already Exists.";
    		 			$ranval=mt_rand(1,1000);
    		 			$finalname=$name."-".$ranval.".".$ext;

    		 			move_uploaded_file($_FILES["file"]["tmp_name"], $path.$finalname);
    		 			echo $finalname." Uploaded in the system <br>";
    		 			echo "Link: <a href='".$path.$finalname."'>".$finalname."</a>";
    				}
    				else
    		  		{
    		   			move_uploaded_file($_FILES["file"]["tmp_name"],$path.$finalname);
    		   			echo $finalname." uploaded in the system <br>";
    		   			echo "Link: <a href='".$path.$finalname."'>".$finalname."</a>";
    		   		}
			}

	}
	else{


		echo "Invalid Document!!";
	}


?>