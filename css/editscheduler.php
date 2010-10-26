<?php 
include('includes/connect.php');
?>
</script><script type="text/javascript">
				$(document).ready(function(){
					$("#cancel").click(function() {
						$("#sch").hide();
						return false;
					});
				});
				</script>
                <div id="sch">
<div id="title">Edit Scheduler</div>


<form name="paper" method="post" action="paper_name_process.php">
						<table border="0" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;">
						
						<tr>
						<td class="login">Paper Name</td>
						<td><select name="paper">
						<option value="0"><?php echo $row['paper_name']; ?></option>
 
						<?php
						$sql = mysql_query("SELECT DISTINCT(paper_name) FROM questionpapers");
						while($row= mysql_fetch_array($sql))
							{
                               echo "<option value='".$row[0]."'>".$row[0]."</option>";
							}
						
							?>
                        </select></td>
						</tr>


						<tr>
						<td class="login">Date</td>
						<td class="ip"><input type="text" id="date" name="date" value="" readonly="readonly" size="13"><td><script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'paper',
		// input name
		'controlname': 'date'
	});</script></td>

						<!-- &nbsp;<img src="images/icon_calendar.png" id="icon_calendar1" width="20" height="17" alt="Calendar" border="0" align="absmiddle" onClick="CalCalender('date','icon_calendar')" /> &nbsp;<small>(dd-mm-yyyy)</small> --> 
						</td>
						</tr>
                       
						
						<tr>
						<td class="login">Start Time</td>
						<td class="ip"><input type="text" size="13" name="start_time" id="start_time" onchange="checktime(this.value);"></td>
						<td><select name="p1" id="p1"><option>A.M</option><option>P.M</option></select></td>
						</tr>

						<tr>
						<td class="login">End Time</td>
						<td class="ip"><input type="text" size="13" name="end_time" id="end_time"></td>
						<td><select name="p2" id="p2"><option>A.M</option><option>P.M</option></select></td>
						</tr>
								
						<tr>
                        <td class="login">Student</td>
                        <td class="ip"><select name="student[]" multiple>							
						    <?php $sql1 = mysql_query("SELECT * FROM students");
							 while($row= mysql_fetch_array($sql1))
							 {
								echo "<option value='".$row[0]."'>".$row[1].' '.$row[2]."</option>";
							 }?>
</select></td>
                        </tr>



						<tr>
						<td><input type="button" name="update" value="UPDATE" id="update"/></td>
						<td><input type="button" name="cancel" value='CANCEL' id="cancel"></td>
						</tr>


</form>
</div>
