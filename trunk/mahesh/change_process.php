<?php
session_start();
include('../includes/connect.php');
$strpass = $_POST['currentpass'];
$strnewpass = $_POST['newpass'];

$sql = "SELECT * FROM students WHERE username ='".$_SESSION['username']."' and password='".$strpass."'"; 
$result = mysql_query($sql);

//echo mysql_num_rows($result);

if(mysql_num_rows($result)){
$sql="Update students set `password`='$strnewpass' where username ='".$_SESSION['username']."' and password='".$strpass."'";
		//echo $sql;
		$result=mysql_query($sql); 

header("location:logoff.php");
}
else
{
header("location:change_password.php");
}

?>