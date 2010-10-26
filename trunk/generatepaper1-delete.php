<?php
<div id="countdoun"></div>
include('includes/connect.php');
$sql="select * from questionpapers where paper_name='".$_GET['papername']."'ORDER BY RAND() ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
while($row=mysql_fetch_row($result))
    {
		$sql2="select * from  questions where questions_id='".$row[2]."'";
		$result1=mysql_query($sql2);
		$ans=mysql_fetch_row($result1);
		echo $ans[1]."<br/>";
		    $sql3="select * from options where questions_id='".$ans[0]."'";
			$result2=mysql_query($sql3);
			  while($row3=mysql_fetch_row($result2))
			    {
					echo "<input type='checkbox' name='options' id='options' value='".$row3[0]."'/>".$row3[0];
				}
				echo "<br/>";
	}
?>