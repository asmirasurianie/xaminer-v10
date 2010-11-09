<?php 
include('includes/connect.php');
?>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" href="calendar/calendar-win2k-cold-1.css">
<script language="JavaScript" type="text/javascript" src="pickerVars.js"></script>
<script language="JavaScript" type="text/javascript" src="picker.js"></script>
<script type="text/javascript">
				$(document).ready(function(){
					$("#cancel").click(function() {
						$("#s").hide();
						return false;
					});
				});
				</script>


<div id="s" class="editprocess">
<div id="title">Edit Scheduler</div>
 <?php 
			$sql ="SELECT * FROM paper_time AS pt, temp_std AS ts, class AS cl,papers as pa WHERE pt.paper_id = ts.paper_id AND cl.class_id = ts.class_id AND pt.paper_id = pa.paper_id AND pa.paper_id='".$_REQUEST['paper_id']."'";
			//echo $sql;
			$result=mysql_query($sql);
			
if(mysql_num_rows($result) >0){
$row1= mysql_fetch_array($result);
$var1=explode(":",$row1['start_time']);
$var2=explode(":",$row1['end_time']);


			?>


<form name="paper" method="post" action="paper_name_change.php">
						<table border="0" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;">
						
						 <tr>
						  <td class="login">Paper Name</td>
						  <td class="ip"><input type="hidden" name="paper_id" value="<?php echo $row1['paper_id'];?>"/><input type="text" size="15" name="paper" value="<?php echo $row1['paper_name'];?>" readonly="readonly" disabled="disabled"/>
						</tr>
						
						
						<tr>
						<td class="login">Date</td>
						<td class="ip"><input type="text" id="date1" name="date1" value="<?php echo $row1['date'];?>"  size="13" ><td>
	 &nbsp;<img src="images/icon_calendar.png" id="icon_calendar" width="20" height="17" alt="Calendar" border="0" align="absmiddle" onMouseOver="CalCalender('date1','icon_calendar')" />
				   &nbsp;<small>(dd-mm-yyyy)</small>&nbsp;&nbsp;<td>
	</td>

						<!-- &nbsp;<img src="images/icon_calendar.png" id="icon_calendar1" width="20" height="17" alt="Calendar" border="0" align="absmiddle" onClick="CalCalender('date','icon_calendar')" /> &nbsp;<small>(dd-mm-yyyy)</small> --> 
						</td>
						</tr>
                       
					   
						
						<tr>
						<td class="login">Start Time</td>
						<td><select name="shours">
						<option value="<?php echo $var1[0];?>"><?php echo $var1[0];?></option>
						<option value="00">00</option>
						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>
						<option value="05">05</option>
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>
						<option value="10">10</option>
					    <option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						</select>
						</td>
						<td><select name="sminutes">
						<option value="<?php echo $var1[1];?>"><?php echo $var1[1];?></option>
						<option value="00">00</option>
						<option value="05">05</option>
						<option value="10">10</option>
						<option value="15">15</option>
						<option value="20">20</option>
						<option value="25">25</option>
						<option value="30">30</option>
						<option value="35">35</option>
						<option value="40">40</option>
						<option value="45">45</option>
						<option value="50">50</option>
						<option value="55">55</option>
						</select>
						</td>
						</tr>

						<tr>
						<td class="login">End Time</td>
						<td><select name="ehours">
						<option value="<?php echo $var2[0];?>"><?php echo $var2[0];?></option>
						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>
						<option value="05">05</option>
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>
						<option value="10">10</option>
					    <option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						</select>
						</td>
						<td><select name="eminutes">
						<option value="<?php echo $var2[1];?>"><?php echo $var2[1];?></option>
						<option value="00">00</option>
						<option value="05">05</option>
						<option value="10">10</option>
						<option value="15">15</option>
						<option value="20">20</option>
						<option value="25">25</option>
						<option value="30">30</option>
						<option value="35">35</option>
						<option value="40">40</option>
						<option value="45">45</option>
						<option value="50">50</option>
						<option value="55">55</option>
						</select>
						</td>
						
						</tr>
						
						<tr>
						<td><input type="submit" name="update" value="UPDATE" id="update"/></td>
						<td><input type="button" name="cancel" value='CANCEL' id="cancel"></td>
						</tr>


</form>
<?php } ?>
</div>

<script type="text/javascript">
    function CalCalender(val,but){

		Calendar.setup({
			inputField     :    val,   // id of the input field
			ifFormat       :    "%d-%m-%Y",       // format of the input field
			daFormat       :    "%d-%m-%Y",       // format of the Display field
			showsTime      :    false,
			button         :    but,
			timeFormat     :    "24",
			step           :    1
		});
		
	}
	   
	   
</script>