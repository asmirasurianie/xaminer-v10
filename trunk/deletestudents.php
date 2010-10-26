<? ob_start(); ?>
<?php
include('includes/connect.php');
$sql="delete from students where std_id=".$_REQUEST['uid'];
		
		$result=mysql_query($sql);

header("location:index.php#students");
?>
<? ob_flush(); ?>