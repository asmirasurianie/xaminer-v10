<? ob_start(); ?>
<?php
include('includes/connect.php');
//require('includes/top.php');
    	$categories = $_REQUEST["category"];
		$date = date("F j, Y, g:i a");
		
		
$cat="select * from categories where category='".$categories."'";
	$catResult=mysql_query($cat);

if(mysql_num_rows($catResult)>0)

		  {
			 header("location:index.php#categories");
		  } 

		  else
				{				


 $sql="INSERT INTO categories(`category`)VALUES('$categories')";
 $result=mysql_query($sql);

				}
				header("location:index.php#categories");

?>
<? ob_flush(); ?> 