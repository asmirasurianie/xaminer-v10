<?php
@session_start();
include('includes/connect.php');
?>

<script type="text/javascript">
 $(document).ready(function(){
  $("#addstudents").click(function(){
  $('#addstudentsform').load('addstudents.php');
  });
	

}); 



</script>
<div id="loadmessage"></div>
<div>
<b style="font-size:14px; color:#900">Manage Students</b><br /><br />
			<?php $sql = mysql_query("select * from students");

if(mysql_num_rows($sql) >0){
	
echo '<table border="0" cellspacing="2px" cellpadding="0px"  width="70%">';
echo '<tr class="tableheader"><td><b>'.'First Name'.'</b></td>'.'<td><b>'.'Last Name'.'</b></td>'.'<td><b>'.'Email Id'.'</b></td>'.'<td><b>'.'Phone'.'</b></td>'.'<td><b>'.'Class'.'</b></td>'.'<td><b>'.'Roll No'.'</b></td>'.'<td><b>'.'Branch'.'</b></td>'.'<td><b>'.'Parents/Gaurdians No.'.'</b></td>'.'<td><b>'.'Edit'.'</b></td>'.'<td><b>'.'Delete'.'</b></td></tr>';
while($row= mysql_fetch_array($sql))
{
	$sql1 = mysql_query("select * from class where class_id=".$row['class_id']);
	$row1= mysql_fetch_array($sql1);
echo '<tr><td>'.$row['first_name'].'</td>'.'<td>'.$row['last_name'].'</td>'.'<td>'.$row['email'].'</td>'.'<td>'.$row['phone_no'].'</td>'.'<td>'.$row1['class'].'</td>'.'<td>'.$row['rollno'].'</td>'.'<td>'.$row['branch'].'</td>'.'<td>'.$row['parentsno'].'</td>'.'<td><a href="editstudents.php?uid='.$row['std_id'].'"><input type="button" value="EDIT" name="Edit" /></a></td>'.'<td><a href="deletestudents.php?uid='.$row['std_id'].'">';?>
<input type="button" value="DELETE" name="delete" onclick="javascript:if(confirm('Are you sure you want to delete this user?')) return true; else return false;"/></a>
<?php
echo '</td></tr>';
}
echo '</table>';
}
else
{
echo '<table border="0" width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
echo '<tr><td>No User Found</td></tr>';
echo '</table>';
}
			?>
			<br>
			<input type="button" id="addstudents" name="addstudents" value="ADD Students" class="submit-butt">
</div>
<hr />

<div id="addstudentsform">
</div>