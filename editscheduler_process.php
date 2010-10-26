<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');
       $paper_name=$_REQUEST['uid'];
        $date=$_POST["date1"];
$shour=$_POST['shours'];
$sminutes=$_POST['sminutes'];
$ehour=$_POST['ehours'];
$eminutes=$_POST['eminutes'];

//$t1=$_POST['p1'];
//$t2=$_POST['p2'];
$paper_name=$_POST['paper'];

$start_time=$shour.":".$sminutes;
$end_time=$ehour.":".$eminutes;
		$strID=$_REQUEST["std_id"];
		
        $date = date("F j, Y, g:i a");
		
		
$sql="Update paper_time set `date`='$date',  `start_time`='$start_time',`end_time`='$end_time' where std_id=".$strID;
		echo $sql;
		//exit;
		$result=mysql_query($sql);


//header("location:index.php#scheduler");
?>
 <? ob_flush(); ?>	