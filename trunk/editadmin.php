<?php
  session_start(); 
  include('includes/connect.php');
?>
<script type="text/javascript">
	$(document).ready(function(){
	$("#cancel").click(function() {
	$("#admin").hide();
	return false;
	});
});
				</script>
<div id="admin" class="editprocess">
<div id="title">Manage Admin</div>


			<?php 
			$sql = mysql_query("select * from users where users_id='".$_REQUEST['uid']."'");

if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);

			?>
	
			 <form name="frmEdituser" id="frmAdduser" method="post" action="editadmin_process.php" enctype="multipart/form-data">
			 <input type="hidden" name="UserId" value="<?php echo $_REQUEST['uid'];?>">
               <table border="0"  width="100%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
			   
                <tr>
				
                  <td>First Name :</td>
				  
                  <td class="login"><input  type="text" id="fname" name="fname" value="<?php echo $row['user_firstname'];?>"></td>
                </tr>
               
				<tr>
				
                  <td>Last Name:</td>
				 
                  <td class="login"><input  type="text" id="lname" name="lname" value="<?php echo $row['user_lastname'];?>"></td>
                </tr>
				 <tr>
				 
                  <td>Username:</td>
				
                  <td class="login" ><input  type="text" name="user" id="user" value="<?php echo $row['username'];?>"></td>
                </tr>
				<tr>
				
                  <td>Password:</td>
				 
                  <td class="login"><input  type="text" name="password" id="password" value="<?php echo $row['password'];?>"></td>
                </tr>
				
                
				<tr>
                  <td colspan="4" align="right">
                 
				   <input type="submit" value="UPDATE" name="update" id="update" />
				   <input type="button" name="cancel" value='CANCEL' id="cancel">
				   
                    </td>
                </tr>
              </table>
            </form>
			
			
			<?php } ;?>
            
</div>