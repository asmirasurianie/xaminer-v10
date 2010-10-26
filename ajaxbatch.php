<?php
session_start();
include('includes/connect.php');
echo '<td class="login">Batch:</td><td class="login">';
echo '<SELECT name="bacth.this.value" id="subject"><option value="SelectSub">Select Subject Name</option>';
 $sql = "SELECT * FROM class where class='".trim($_REQUEST['class'])."'";
		$result = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($result) >0){
	while($row = mysql_fetch_assoc($result)){
		echo '<option value="'.$row[0].'">'. $row[0] .'</option>';

		}
}		
else
{
echo '<option value="0">'. 'No Records Found' .'</option>';
}		
echo '</SELECT></td>';
?>