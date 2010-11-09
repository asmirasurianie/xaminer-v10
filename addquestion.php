<?php
	session_start();
	include('includes/connect.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title> Xaminer :: Add Questions </title>
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<script type="text/javascript">
		<!--
			var newEditor;
		//-->
		</script>
		<script src="js/jquery-1.1.3.1.pack.js" type="text/javascript"></script>
		<script src="js/jquery.history_remote.pack.js" type="text/javascript"></script>
		<script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/common.js"></script>
		<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" src="js/tiny.js"></script>
		<script type="text/javascript" src="js/editor.js"></script>
	</head>

	<body onLoad="reloadMCE();">
  
<?php
	if(@$_REQUEST['er']==2) {
		echo '<b style="color:red;">Please select the options.</b>';
	} 
?>

</p>
<form name="addquestion" id="addquestion" method="post" action="addmorequestion.php" enctype="multipart/form-data">
	<table border="0">
		<tr>
			<td>
				Add a question using the rich text editor on the left. <br/><b class="message">Note : The equation editor on the right can be used to create complex mathematical equations</b>
			</td>
			<td align="right">
				<input type="submit" value="submit" id="addquestion" name="addquestion" class="sub-butt" onclick="return submitquescheck();" />
				<input type="button" value="cancel" class="sub-butt" onclick="cancelme();return false;"/>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
				<table width="100%" border="0" height="100px" bgcolor="#EEEEEE">
					<tr>
						<td align="right" width="30%">Choose the class : </td>
						<td align="left">
							<select name="sclass" id="sclass">
								<option value="0">Select Class</option>
								<?php
									$query="select * from class";
									$result=mysql_query($query);
									while($row=mysql_fetch_row($result))
									{
										echo "<option value='".$row[0]."'>".$row[1]."</option>";
									}
								?>
							</select>
							<div id="rs1"></div>
						</td>
					</tr>
					<tr>
						<td align="right">Choose the question category : </td>
						<td align="left">
							<select name="scategory" id="scategory">
								<option value="0">Select Category</option>
								<?php
									$query="select * from categories";
									$result=mysql_query($query);
									while($row=mysql_fetch_row($result))
									{
										echo "<option value='".$row[0]."'>".$row[1]."</option>";
									}
								?>
							</select>
							<div id="rs2"></div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
				<table width="100%" border="1">
					<tr>
						<td width="50%"><textarea id="question0" name="question0" rows="20" cols="50"></textarea></td>
						<td align="center"><a href="javascript:OpenLatexEditor('testbox','html','')">Launch Equation Editor</a><br/>
							<input type="text" id="testbox" style="height:0px;width:0px;border:0px" onChange="showImg()"><br/>
						</td>
					</tr>
				</table>
				
			</td>
			<td>
				<div id="rq0"></div>
			</td>
		</tr>
		<!--
		<tr>
			<td>Upload Image:</td>
			<td><input type="file" name="file0" id="file0"/></td>
			<td></td>
		</tr>
		-->
		<tr>
			<td>
				<label>Marks&nbsp;:&nbsp;</label><input type="text" name="marks0" id="marks0" size="25" />
			</td>
			<td>
				
			</td>
			<td>
				<div id="rm0"></div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<input type="hidden" value="0" id="theValue0"/>
				<div id="myDiv"></div><a href="javascript:addoption();">Add Options</a>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="myQues"></div>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input type="hidden" value="0" id="theQuestion"/>
				<a href="javascript:addquestion();">Add more questions</a> <!-- <a href="#" onclick="reloadMCE()">reload</a> -->
			</td>
			<td align="right">

				<input type="submit" value="submit" id="addquestion" name="addquestion" class="sub-butt" onclick="return submitquescheck();"/>

				<input type="button" value="cancel" class="sub-butt" onclick="cancelme();return false;"/>
			</td>
			<td></td>
		</tr>
	</table>
</form>
<div id="loading"></div>




