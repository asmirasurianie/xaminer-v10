<?php
include('includes/connect.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<div id="categories_form">
  <div id="resultdisplay"></div>
<form name="frmcategories" id="frmcategories" method="post" action="addcategories_process.php">
               
               <table   border="0" width="50%" cellspacing="3" cellpadding="2"  align="left">
			   <tr>
			   <td colspan="2" style="font-size:16px; color:#C60;"><h3><u>Add categories</u></h3></td>
			   </tr>
               <tr>
                  <td class="login"><label>Category :</label></td>
                  <td class="login"><input type="text" id="category" name="category"></td>
               </tr>
               <tr>
				 <td colspan="2">&nbsp;</td>
		    	 </tr>
                <tr>
                  <td>
				   <input type="submit" value="SUBMIT" name="addcategories" id="addcategories" onclick="return checkcategory();" class="sub-butt"/>
                    &nbsp;</td>
				 <td >
				    <input type="button" value="cancel" class="sub-butt" onclick="cancelcategory();return false;"/>
                    &nbsp;</td>	
                </tr>
              </table>
            </form>
			
</div>