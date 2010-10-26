<?php

include('includes/connect.php');
session_start();
//require('includes/top.php');
$paperid=$_POST['paper_id'];
$date=$_POST["date1"];
$shour=$_POST['shours'];
$sminutes=$_POST['sminutes'];
$ehour=$_POST['ehours'];
$eminutes=$_POST['eminutes'];

//$t1=$_POST['p1'];
//$t2=$_POST['p2'];


$start_time=$shour.":".$sminutes;
$end_time=$ehour.":".$eminutes;



$query="Update paper_time set `date`='$date',  `start_time`='$start_time',`end_time`='$end_time' where paper_id ='".$paperid."'";

mysql_query($query) or die(mysql_error());
header("Location:index.php#scheduler");

?>

