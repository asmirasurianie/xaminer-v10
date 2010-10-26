<?php
include('includes/connect.php');
?>
<!--[if ie 8]>
<script src="js/jquery-1.2.3.pack.js"></script>
<script src="js/runonload.js"></script>
<script src="js/tutorial.js"></script>
<![endif]-->
<!-- <script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script> -->
<div id="classes_form">
<div id="resultdisply"></div>
<form name="frmAddStandard" id="frmAddStandard" method="post" enctype="multipart/form-data" action="addclasses_process.php">
               <table border="0"  cellspacing="3" cellpadding="2"  align="left">
			   <tr>
			   <td colspan="2" style="font-size:16px; color:#C60;"><h3><u>Add classes</u></h3></td>
			   </tr>
                <tr>
                  <td><label>Class :</label></td>
                  <td><input type="text" id="cla123" name="cla123"></td>
				</tr>
                <tr>
                  <td><label>Batch :</label></td>
                  <td><input type="text" id="batch" name="batch"></td>
				</tr>
                <tr>
				<td colspan="2">&nbsp;</td>
				</tr>
                <tr>
                  <td >
				   <input type="submit" value="SUBMIT" name="addclass" id="addclass" onclick="return checkclass();" class="sub-butt" />
                    &nbsp;</td>
				<td >
				    <input type="button" value="cancel" class="sub-butt" onclick="cancelclass();return false;"/>
                    &nbsp;</td>	
                </tr>
              </table>
</form>
</div>	