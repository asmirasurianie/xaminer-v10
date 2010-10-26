<?php
session_start();
include('includes/connect.php');
?>


<script type="text/javascript">
 $(document).ready(function(){
  $("#addclasses").click(function(){
  $('#addclassesform').load('addclasses.php');
  });
}); 
</script>
<div>
<b style="font-size:15px; color:#900">Manage Classes</b><br /><br />
<?php $sql = mysql_query("select * from class ORDER BY class ASC ");

if(mysql_num_rows($sql) >0){
echo '<table border=0 cellspacing="2px" cellpadding="0px"  width="70%">';
echo '<tr class="tableheader"><td colspan="3"><b>'.'Class'.'</b></td></tr>';
while($row= mysql_fetch_array($sql))
{

echo '<tr><td width="100">'.$row['class'].'</td><td width="80"><a href="editstandard.php?stid='.$row['class_id'].'"><input type="button" value="EDIT" name="Edit" class="submit-butt" /></a></td>'.'<td width="80"><a href="deletestandard.php?stid='.$row['class_id'].'">';?>
<input type="button" value="DELETE" name="delete" onclick="javascript:if(confirm('Are you sure you want to delete this standard?')) return true; else return false;" class="submit-butt" /></a>
<?php
echo '</td></tr>';
}
echo '</table>';
}
else
{
echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
echo '<tr><td>No Class Found</td></tr>';
echo '</table>';
}

?>
<br>
<input type="button" style="width:130px; height:35px;font-weight:bolder;" id="addclasses" name="addclasses" value="Add Class" class="submit-butt">
</div>

<div id="addclassesform"></div>

