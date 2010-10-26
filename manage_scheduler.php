<table  border="0" cellpadding="2" cellspacing="2"  > 
  <tr class="main">
    <td colspan="2" align="center" class="errorText"><b><div id="resultshere1" class="error"></div></b></td>
  </tr>
  </table>



<table border="0">
  <tr>
</td>

    <td>	          
     <table border="0">
         <tr valign="top">
          <td><fieldset>
            <legend><b>Manage Scheduler</b></legend>
			<?php $sql = mysql_query("select * from paper_time");

if(mysql_num_rows($sql) >0){
echo '<table border=1 cellspacing="0px" cellpadding="0px"  class="managetable">';
echo '<tr class="tableheader"><td><b>'.'Paper Name'.'</b></td>'.'<td><b>'.'Start Time'.'</b></td>'.'<td><b>'.'End Time'.'</b></td>'.'<td><b>'.'Date'.'</b></td></tr>';
while($row= mysql_fetch_array($sql))
{

echo '<tr><td>'.$row['paper_name'].'</td>'.'<td>'.$row['start_time'].'</td>'.'<td>'.$row['end_time'].'</td>'.'<td>'.$row['date'].'</td>'.'<td><a href="editscheduler.php?uid='.$row['users_id'].'"><input type="button" value="EDIT" name="Edit" /></a></td>'.'<td><a href="deletescheduler.php?uid='.$row['users_id'].'">';?>
<input type="button" value="DELETE" name="delete" onclick="javascript:if(confirm('Are you sure you want to delete this user?')) return true; else return false;"/></a>
<?php
echo '</td></tr>';
}
echo '</table>';
}
else
{
echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
echo '<tr><td>No User Found</td></tr>';
echo '</table>';
}
			?>
			<br>
			<input type="button" style="width:110px; height:35px; font-weight:bolder;" onClick="javascript:document.location.href='addexamscheduler.php'" name="paper_name" value="Add Scheduler">
            </fieldset>
      </td>
       </tr>
      </table>
             </td>
  </tr>
</table>