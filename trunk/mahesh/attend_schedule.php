<?php
session_start();
include('../includes/connect.php');
?>


<table border="0">
  <tr>
</td>

    <td>	          
     <table border="0">
         <tr valign="top">
          <td>
		  <h3> Attend Exam</h3>
			<?php $sql = mysql_query("select * from class_std as cst,students as std where cst.std_id=std.std_id and std.username='".$_SESSION['username']."' and cst.attempt='1'");

if(mysql_num_rows($sql) >0){
echo '<table border=1 cellspacing="0px" cellpadding="0px"  class="managetable">';
echo '<tr class="tableheader"><td><b>'.'Paper Name'.'</b></td></tr>';
while($row= mysql_fetch_array($sql))
{

echo '<tr><td>'.$row['paper_name'].'</td></tr>';

}
echo '</table>';
}
else
{
echo '<table border=0 width="50%" style="border:#000 1px solid; padding-left:20px;">';
echo '<tr><td>No students Found</td></tr>';
echo '</table>';
}
			?>
			<br>
			
            
      </td>
       </tr>
      </table>
             </td>
  </tr>
</table>
 