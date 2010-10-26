<? ob_start(); ?>
<?php
include('includes/connect.php');
$sql="delete from questions where questions_id='".$_REQUEST['qid']."'";
		
$result=mysql_query($sql);

header("location:index.php#questions");
?>
<? ob_flush(); ?>