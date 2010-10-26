<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');
        $strClass = $_REQUEST["class"];
    	//echo $strCategory;
		$strClassID=$_REQUEST['class_id'];
		//echo $strCategoryID;
$sql="Update class set `class`='$strClass' where class_id=".$strClassID;
		
$result=mysql_query($sql);


header("location:index.php#classes");
?>
<? ob_flush(); ?>