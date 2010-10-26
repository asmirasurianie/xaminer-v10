<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');
        $strUid = $_POST["UserId"];
    	$strFName = $_POST["fname"];
		$strLName = $_POST["lname"];
		$strEmail = $_POST["email_id"];
		$strBranch = $_POST["branch"];
		$strUserName = $_POST["username"];
		$strPassword = $_POST["password"];
		$strQuestion = $_POST["squestion"];
		$strAnswer = $_POST["sanswer"];
        $date = date("F j, Y, g:i a");
		
		
$sql="Update users set `users_id`='$strUid',  `user_firstname`='$strFName',`user_lastname`='$strLName',`email_id`='$strEmail',`branch`='$strBranch',`username`='$strUserName',`password`='$strPassword',`user_created`='$date' where users_id=".$strUid;
		//echo $sql;
		//exit;
		$result=mysql_query($sql);


header("location:index.php#examiner");
?>
<? ob_flush(); ?> 