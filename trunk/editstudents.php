<?php 
include('includes/connect.php');
?>
<script type="text/javascript">
				$(document).ready(function(){
					$("#cancel").click(function() {
						$("#editstudentsform").hide();						
						return false;
					});
				});
				</script>
<div id="editstudentsform" class="editprocess">
<div id="title">Edit student</div>
		  <?php 
			$sql = mysql_query("select * from students where std_id='".$_REQUEST['uid']."'");

if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);
 $que1="select * from class where class_id='".$row['class_id']."'";
 $result=mysql_query($que1);
 $row1=mysql_fetch_row($result);

			?>
			
			
			   <form name="frmAddStandard" id="frmAdduser" method="post" action="editstudents_process.php" enctype="multipart/form-data">
			   <input type="hidden" name="std_id" value="<?php echo $_REQUEST['uid'];?>">
               <table  border="0" width="100%" cellspacing="4" cellpadding="2"  align="left" summary="Password Forgoten Table">
			                   <tr><td>&nbsp;</td></tr>
							   <tr>
							   <td>&nbsp</td>
                 <td>First Name :</td>
				 
                  <td class="ip" ><input type="text" id="fname" name="fname" value="<?php echo $row['first_name'];?>"></td>
                </tr>
                <tr>
				<td>&nbsp</td>
                  <td>Last Name :</td>
				
				  <td class="ip"><input type="text" id="lname" name="lname" value="<?php echo $row['last_name'];?>"></td>
                </tr>
				 <tr>
				 <td>&nbsp</td>
                  <td>Email ID :</td>
				
                  <td class="ip"><input type="text" id="email" name="email" value="<?php echo $row['email'];?>"></td>
                </tr>
				 <tr>
				 <td>&nbsp</td>
                  <td>Phone :</td>
			
                  <td class="ip"><input type="text" id="phone_no" name="phone_no" value="<?php echo $row['phone_no'];?>"></td>
                </tr>
				 <tr>
				 <td>&nbsp</td>
                  <td>Class :</td>
				
                  <td class="ip"><select id="class_id" name="class">
	 <?php
	    $query1="select * from class";
		$result1=mysql_query($query1);
		while($row1=mysql_fetch_row($result1))
		  {
		     if($row1[0]==$row['class_id'])
			  {
				echo "<option value='".$row1[0]."' selected='selected'>".$row1[1]."</option>";
			  }
			  else
			  {
				  echo "<option value='".$row1[0]."'>".$row1[1]."</option>";
			  }
		  }
	 ?>
	 </select></td>
                </tr>

				 <tr>
				 <td>&nbsp</td>
                  <td>Roll No:</td>
				  
                  <td class="ip"><input type="text" id="rollno" name="rollno" value="<?php echo $row['rollno'];?>"></td>
                </tr>

				<tr>
				<td>&nbsp</td>
                  <td>Branch:</td>
				 
                  <td class="ip"><input type="text" id="branch" name="branch" value="<?php echo $row['branch'];?>"></td>
                </tr>

				<tr>
				<td>&nbsp</td>
                  <td>Parents/Gaurdians No.:</td>
				 
                  <td class="ip"><input type="text" id="parentsno" name="parentsno" value="<?php echo $row['parentsno'];?>"></td>
                </tr>
                <tr>
				<td>&nbsp</td>
                  <td>User Name.:</td>
				
                  <td class="ip"><input type="text" id="username" name="username" value="<?php echo $row['username'];?>"></td>
                </tr>
                <tr>
				<td>&nbsp</td>
                  <td>Password:</td>
				
                  <td class="ip"><input type="text" id="password" name="password" value="<?php echo $row['password'];?>"></td>
                </tr>
				<tr><td>&nbsp;</td></tr>
                
				<tr>
                  <td></td>
				  <td colspan="2" align="right"><input type="submit" value="UPDATE" name="update" id="update"/>
				  <input type="button" name="cancel" value='CANCEL'  id="cancel"></td>
                </tr>
				
				
              </table>
            </form>
				<?php } ;?>
</div>