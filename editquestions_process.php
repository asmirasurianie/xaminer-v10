<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');
		$strID=$_REQUEST['qid'];
        $strQue = $_REQUEST["question"];
    	$strSClass=$_REQUEST['sclass'];
		$strSCategory=$_REQUEST['scategory'];
		$strMarks=$_REQUEST['marks'];

//echo $strID;
//echo $strQue;
//echo $strSClass;
//echo $strSCategory;
//echo $strMarks;
//echo $strCategoryID;

$sql="Update questions set `questions`='$strQue',`category_id`='$strSCategory',`class_id`='$strSClass',`marks`='$strMarks' where questions_id=".$strID;
$result=mysql_query($sql);		

header("location:index.php#questions");
?>
<? ob_flush(); ?>