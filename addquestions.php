<?php
  require('includes/top.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Xaminer</title>
<base href="<?php BASE_PATH ?>">
<link rel="stylesheet" type="text/css" href="templates/stylesheet.css">
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="timepickerb.js"></script>
<script type="text/javascript" src="timepick.js"></script>
<script type="text/javascript" src="timepickerb.js"></script>
<script language="JavaScript" src="calendar_us.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.js"></script>
<link rel="stylesheet" href="calendar.css">
</head>
<body>
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
            <legend><b>Add Questions</b></legend>		
     <form name="addquestion" id="addquestion" method="post" action="">
     <table><tr><td><label>Question:</label></td><td><textarea name="question" id="question"></textarea></td><td><div id="question_error"></div></td></tr>
	 <tr><td><label>Class:</label></td><td><select name="sclass" id="sclass"><option value="0">Select Class</option>
	 <?php
	    $query="select * from class";
		$result=mysql_query($query);
		while($row=mysql_fetch_row($result))
		  {
		     echo "<option value='".$row[0]."'>".$row[1]."</option>";
		  }
	 ?>
	 </select>
     </td><td><div id="cla_error"></div></td></tr>
     <tr><td><label>Category:</label></td><td><select name="scategory" id="scategory"><option value="0">Select Category</option>
	 <?php
	    $query="select * from categories";
		$result=mysql_query($query);
		while($row=mysql_fetch_row($result))
		  {
		     echo "<option value='".$row[0]."'>".$row[1]."</option>";
		  }
	 ?>
	 </select></td><td><div id="cat_error"></div></td></tr>
	 <tr><td><label>Marks:</label></td><td><input type="text" name="marks" id="marks" size="25" /></td><td><div id="nark_error"></div></td></tr>
	 <tr><td><input type="submit" value="submit" id="addquestion" name="addquestion" onclick="submitquestion();return false;"/></td>
	 <td><input type="reset" value="cancel"/></td></tr>
     </table>
  </form>
   </fieldset>
  
  <div id="loading"></div>
 <div id="answer"></div>
 
 </body>
 </html>



