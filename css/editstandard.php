<?php 
include('includes/connect.php');
?>
</script><script type="text/javascript">
				$(document).ready(function(){
					$("#cancel").click(function() {
						$("#clas").hide();
						return false;
					});
				});
				</script>
<div id="clas">
<div id="title">Edit Class</div>


		  <?php 
			$sql = mysql_query("select * from class where class_id='".$_REQUEST['stid']."'");

if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);

			?>

			
				 <form name="frmAddStandard" id="frmAdduser" method="post" action="editstandard_process.php" enctype="multipart/form-data">
				 	 <input type="hidden" name="class_id" value="<?php echo $_REQUEST['stid'];?>">
               <table  border="0" width="70%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
			  
                <tr>
                  <td class="login">Class :</td>
                  <td class="login"><input type="text" id="class" name="class" value="<?php echo $row['class'];?>"></td>
                </tr>
                <tr>
				<td colspan="2">&nbsp;</td>
				</tr>
                <tr>
				<td></td>
                  <td valign="top" colspan="2" align="center">
				   <input type="submit" value="UPDATE" name="update" id="update"/>
                   </td>
				   <td><input type="button" name="cancel" value='CANCEL'  id="cancel"></td>
                </tr>
              </table>
            </form>
				<?php } ;?>
</div>
			   