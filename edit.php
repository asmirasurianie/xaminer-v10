<?php 
include('includes/connect.php');
?>
</script><script type="text/javascript">
				$(document).ready(function(){
					$("#cancel").click(function() {
						$("#euser").hide();
						return false;
					});
				});
				</script>
<div id="euser" class="editprocess">
<div id="title">Edit User</div>

			<?php 
			$sql = mysql_query("select * from users where users_id='".$_REQUEST['uid']."'");

if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);

			?>
	
			 <form name="frmEdituser" id="frmAdduser" method="post" action="edituser_process.php" enctype="multipart/form-data">
			 <input type="hidden" name="UserId" value="<?php echo $_REQUEST['uid'];?>">
               <table   border="0" width="100%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
			
                <tr>
                  <td>First Name :</td>
                  <td class="ip"><input  type="text" id="fname" name="fname" value="<?php echo $row['user_firstname'];?>"></td>
                </tr>
                <tr>
                  <td>Last Name:</td>
                  <td class="ip"><input  type="text" id="lname" name="lname" value="<?php echo $row['user_lastname'];?>"></td>
                </tr>
                <tr>
                  <td>Email ID:</td>
                  <td class="ip"><input  type="text" id="email_id" name="email_id" value="<?php echo $row['email_id'];?>"></td>
                </tr>
                <tr>
                  <td>Branch:</td>
                  <td class="ip"><input  type="text" id="branch" name="branch" value="<?php echo $row['branch'];?>"></td>
                </tr>
				 <tr>
                  <td>Username:</td>
                  <td class="ip" ><input  type="text" name="username" id="username" value="<?php echo $row['username'];?>"></td>
                </tr>
				<tr>
                  <td>Password:</td>
                  <td class="ip"><input  type="text" name="password" id="password" value="<?php echo $row['password'];?>"></td>
                </tr>				
			
                <tr>
                  <td valign="top" colspan="2" align="center">
				   <input type="submit" value="UPDATE" name="update" id="update"/></td>
				   <td><input type="button" name="cancel" value='CANCEL' id="cancel">
				   
                    &nbsp;</td>
                </tr>
              </table>
            </form>
			
			
			<?php } ;?>
  </div>