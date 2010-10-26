<?php 
include('includes/connect.php');
?>
<div id="title">Edit student</div>
		  <?php 
			$sql = mysql_query("select * from students where std_id='".$_REQUEST['uid']."'");

if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);

			?>

			
			   <form name="frmAddStandard" id="frmAdduser" method="post" action="editstudents_process.php" enctype="multipart/form-data">
			   <input type="hidden" name="std_id" value="<?php echo $_REQUEST['uid'];?>">
               <table  border="0" width="30%" cellspacing="4" cellpadding="2"  align="left" summary="Password Forgoten Table">
			                   <tr><td>&nbsp;</td></tr>
							   <tr>
							   <td>&nbsp</td>
                 <td class="login" >First Name :</td>
				 
                  <td class="ip" ><input type="text" id="fname" name="fname" value="<?php echo $row['first_name'];?>"></td>
                </tr>
                <tr>
				<td>&nbsp</td>
                  <td class="login" >Last Name :</td>
				
				  <td class="ip"><input type="text" id="lname" name="lname" value="<?php echo $row['last_name'];?>"></td>
                </tr>
				 <tr>
				 <td>&nbsp</td>
                  <td class="login" >Email ID :</td>
				
                  <td class="ip"><input type="text" id="email" name="email" value="<?php echo $row['email'];?>"></td>
                </tr>
				 <tr>
				 <td>&nbsp</td>
                  <td class="login" >Phone :</td>
			
                  <td class="ip"><input type="text" id="phone_no" name="phone_no" value="<?php echo $row['phone_no'];?>"></td>
                </tr>
				 <tr>
				 <td>&nbsp</td>
                  <td class="login" >Class :</td>
				
                  <td class="ip"><input type="text" id="class_id" name="class" value="<?php echo $row['class_id'];?>"></td>
                </tr>

				 <tr>
				 <td>&nbsp</td>
                  <td class="login" >Roll No:</td>
				  
                  <td class="ip"><input type="text" id="rollno" name="rollno" value="<?php echo $row['rollno'];?>"></td>
                </tr>

				<tr>
				<td>&nbsp</td>
                  <td class="login">Branch:</td>
				 
                  <td class="ip"><input type="text" id="branch" name="branch" value="<?php echo $row['branch'];?>"></td>
                </tr>

				<tr>
				<td>&nbsp</td>
                  <td class="login">Parents/Gaurdians No.:</td>
				 
                  <td class="ip"><input type="text" id="parentsno" name="parentsno" value="<?php echo $row['parentsno'];?>"></td>
                </tr>
                <tr>
				<td>&nbsp</td>
                  <td class="login">User Name.:</td>
				
                  <td class="ip"><input type="text" id="username" name="username" value="<?php echo $row['username'];?>"></td>
                </tr>
                <tr>
				<td>&nbsp</td>
                  <td class="login">Password:</td>
				
                  <td class="ip"><input type="text" id="password" name="password" value="<?php echo $row['password'];?>"></td>
                </tr>
				<tr><td>&nbsp;</td></tr>
                
				<tr>
                  <td class="login"></td>
				  <td colspan="2" align="right"><input type="submit" value="UPDATE" name="update" id="update"/>
				  <input type="button" name="cancel" value='CANCEL' onclick="history.go(-1)" id="cancel"></td>
                </tr>
				
				
              </table>
            </form>
				<?php } ;?>
