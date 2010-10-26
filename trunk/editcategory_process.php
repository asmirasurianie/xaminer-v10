<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');
        $strCategory = $_REQUEST["category"];
    	
		$strCategoryID=$_REQUEST['category_id'];
		
$sql="Update categories set `category`='$strCategory' where category_id=".$strCategoryID;
		
$result=mysql_query($sql);


header("location:index.php#categories");
?>
<? ob_flush(); ?>