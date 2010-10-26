<? ob_start(); ?>
<?php
include('includes/connect.php');

$sql="delete from paper_time where paper_id='".$_REQUEST['paper_id']."'";
$result=mysql_query($sql);

if($result)
{
	$sql1="delete from temp_std where paper_id='".$_REQUEST['paper_id']."'";
    $result1=mysql_query($sql1);

}

header("location:index.php#scheduler");
?>
<? ob_flush(); ?>