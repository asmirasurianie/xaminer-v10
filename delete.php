<? ob_start(); ?>
<?php
include('includes/connect.php');
$sql="delete from users where users_id=".$_REQUEST['uid'];
		
		$result=mysql_query($sql);

header("location:index.php#examiner");
?>
<? ob_flush(); ?>
