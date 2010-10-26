<?php 
include('includes/connect.php');
?>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript" src="pickerVars.js"></script>
<script language="JavaScript" type="text/javascript" src="picker.js"></script>
<link rel="stylesheet" type="text/css" href="calendar/calendar-win2k-cold-1.css">

<table  border="0" cellpadding="2" cellspacing="2"> 
  <tr class="main">
    <td colspan="2" align="center" class="errorText"><div id="resultshere1" class="error">
    <b><?php
	 if($_REQUEST['er']==1)
	{
	echo 'Already Selected Scheduler';
	}
	?></b></div>
    </td>
  </tr>
  </table>
<div style="border:1px solid #e8a41f; width:550px; overflow:auto">
<form name="paper" method="post" action="paper_name_process.php">
					<table border="0"  width="100%" cellspacing="3" cellpadding="2"  align="left">
						<tr>
                        <td colspan="2" style="font-size:16px; color:#C60;"><h3><u>Add Scheduler</u></h3></td>
                        </tr>
						<tr>
						<td>Paper Name</td>
						<td><select name="paper">
						<option value="0">Select paper</option>
 
						<?php
						$sql = mysql_query("SELECT * FROM papers");
						while($row= mysql_fetch_array($sql))
							{
                               echo "<option value='".$row[0]."'>".$row[1]."</option>";
							}
						
							?>
                        </select></td>
						</tr>
                        <tr>
                        <td>Date:</td>
						<td>
						<input  type="text" id="doc" name="doc" value="" readonly="readonly" size="15">
				  &nbsp;<img src="images/icon_calendar.png" id="icon_calendar" width="20" height="17" alt="Calendar" border="0" align="absmiddle" onMouseOver="CalCalender('doc','icon_calendar')" />
				   &nbsp;<small>(dd-mm-yyyy)</small>&nbsp;&nbsp;<td>
						<td>	</td>
						</tr>
						
						<tr>
						  <td><input type="checkbox" name="a1" id="a1"/>All Time</td>
						</tr>

						
						<tr>
						<td>Start Time</td>
						<td><select name="shours"><option value="00">00</option>
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
						<td>End Time</td>
						<td><select name="ehours"><option value="00">00</option>
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
						  <td><input type="checkbox" name="a2" id="a2"/>One quetion per page</td>
						</tr>						                        
                        <tr>
						<td><input type="submit" name="Submit" value="SUBMIT"/></td>
						</tr>
						
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