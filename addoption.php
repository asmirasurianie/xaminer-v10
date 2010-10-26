<div id="optionval">
<div id="displayerror"></div>
<fieldset style="width:400px;"><legend><b>Add Options</b></legend>
<form name="addquestion" id="addquestion" method="post" action="addoption_process.php">
<input type="hidden" value="0" id="theValue"/>
<div id="myDiv"></div>
<p><a href="javascript:addoption();" >Add Options</a></p>
<div id="answerid"></div>
<input type="submit" value="Submit" id="addoption" name="addoption" onclick="return checkoption123();"/>
<input type="button" value="cancel" onClick="getquestion(xhr)"/></form>
</fieldset>
</div>