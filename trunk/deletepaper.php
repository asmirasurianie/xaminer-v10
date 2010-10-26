<? ob_start(); ?>
<?php
include('includes/connect.php');
//echo $_REQUEST['paper_name'];
$sql="delete from questionpapers where paper_id='".trim($_REQUEST['paper_id'])."'";
$result=mysql_query($sql);
if($result) {
$sql1="delete from papers where paper_id='".trim($_REQUEST['paper_id'])."'";
$result1=mysql_query($sql1);
}
		
header("location:index.php#generate");
?>
<? ob_flush(); ?>