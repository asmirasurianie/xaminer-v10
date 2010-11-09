<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');

    	$classes = $_POST["cla123"];
		$batch = $_POST["batch"];
		
	$class="select * from class where class='".$classes."' and batch='".$batch."'";
	$classResult=mysql_query($class);
	
	
	if(mysql_num_rows($classResult)>0)

		  {
			  header("location:index.php#classes");
		  } 

		  else
				{				
 $sql="INSERT INTO class(`class`,`batch`) VALUES ('$classes','$batch')";
 $result=mysql_query($sql);
 if($result)
 {
	 header("location:index.php#classes");
 }
				}



?>
<? ob_flush(); ?> 