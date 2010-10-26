<?php
include('../includes/connect.php');
//require('includes/top.php');
    	$strFName = $_REQUEST["fname"];
		$strLName = $_REQUEST["lname"];
		$strEmail = $_REQUEST["email"];
		$strPhone = $_REQUEST["phone"];
		$strClass = $_REQUEST["classname"];
		$strRollno = $_REQUEST["rollno"];
		$strBranch = $_REQUEST["branch"];
		$strParentsno = $_REQUEST["parentsno"];
		
$r = '';
		for($j=0; $j<5; $j++)
			$r .= chr(rand(0, 25) + ord('1'));

$sql1="select * from students where std_id='1'";
$result1=mysql_query($sql1);
		
$row1=mysql_fetch_array($result1);

$sql="INSERT INTO students(first_name, last_name, email, phone_no,class_id,rollno,branch, parentsno,username,password,confirm) VALUES ('$strFName', '$strLName', '$strEmail', '$strPhone', '$strClass','$strRollno','$strBranch','$strParentsno','$strFName','$r','0')";
$result=mysql_query($sql);
   

header("location:index.php#registration");
?>