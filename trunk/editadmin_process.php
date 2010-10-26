<? ob_start(); ?>
<?php
require('includes/connect.php');
        $strUid = $_POST["UserId"];
    	$strFName = $_POST["fname"];
		$strLName = $_POST["lname"];
		$strUser = $_POST["user"];
		$strPassword = $_POST["password"];
		$strQuestion = $_POST["squestion"];
		$strAnswer = $_POST["sanswer"];
        $date = date("F j, Y, g:i a");
		
		
$sql="Update users set `user_firstname`='$strFName',`user_lastname`='$strLName',`username`='$strUser',`password`='$strPassword',`user_created`='$date' where users_id=".$strUid;
		//echo $sql;
		//exit;
		$result=mysql_query($sql);
		if($result)
		{
			header("location:login.php?upacc=1");
		}
		else {
		echo "as";
		}
			  



?>
<? ob_flush(); ?>