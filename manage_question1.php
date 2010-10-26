<?php
session_start();
include('includes/connect.php');
?>

<script type="text/javascript">
 $(document).ready(function(){
  $('#addquestion1').click(function(){
  $('#addquestionform').load('addquestion.php');
  });
}); 
</script>
<div>
<b style="font-size:15px; color:#900">Manage Questions</b><br /><br />
		<?php $sql = mysql_query("select * from questions,class where questions.class_id=class.class_id ORDER BY questions ASC ");
			
			if(mysql_num_rows($sql) >0)
			{
                  echo '<table border=1 cellspacing="0px" cellpadding="0px"  class="managetable">';
                  echo '<tr class="tableheader"><td><b>'.'Questions'.'</b></td><td><b>'.'Class'.'</b></td><td colspan=3><b>'.'Marks'.'</b></td></tr>';
                    while($row= mysql_fetch_array($sql))
                     {

                        echo '<tr><td>'.$row['questions'].'</td><td>'.$row['class'].'</td><td>'.$row['marks'].'</td><td width="80"><a href="editstandard.php?stid='.$row['category_id'].'"><input type="button" value="EDIT" name="Edit" /></a></td>'.'<td width="80"><a href="deletestandard.php?stid='.$row['category_id'].'"></a> <input type="button" value="DELETE" name="delete"/>';
					
                        echo '</td></tr>';
                     }
                 echo '</table>';
            }
         else
          {
                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                echo '<tr><td>No Questions Found</td></tr>';
                echo '</table>';
          }

?>
			<br>
			<input type="button" style="width:130px; height:35px;font-weight:bold;" id="addquestion1" name="addquestion1" value="Add Question" class="submit-butt">
<div id="addquestionform"></div>
<div id="loading">
</div>
</div>

