<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');
	$strID=$_REQUEST["std_id"];
    $strfname=$_REQUEST["fname"];
	$strlname=$_REQUEST["lname"];
	$strEmail=$_REQUEST["email"];
	$strPhone_no=$_REQUEST["phone_no"];
	$strClass_id=$_REQUEST["class"];
	$strRollno=$_REQUEST["rollno"];
	$strBranch=$_REQUEST["branch"];
	$strParentsno=$_REQUEST["parentsno"];
	$strusername=$_REQUEST["username"];
	$strpassword=$_REQUEST["password"];
		
$sql="Update students set `first_name`='$strfname',`last_name`='$strlname',`email`='$strEmail',`phone_no`='$strPhone_no',`class_id`='$strClass_id',`rollno`=$strRollno,`branch`='$strBranch',`parentsno`='$strParentsno',`username`='$strusername',`password`='$strpassword' where std_id=".$strID;
 		
$result=mysql_query($sql);

header("location:index.php#students"); 
?>
<? ob_flush(); ?>