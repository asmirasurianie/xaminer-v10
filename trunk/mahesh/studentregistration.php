<?php
include('../includes/connect.php');
?>
<script type="text/javascript" src="js/common.js"></script>
<form name="frmAdduser" id="frmAdduser" method="post"  enctype="multipart/form-data" action="studentregistration_process.php">
    <table   border="0" width="40%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
        <tr>
        	<td colspan="2" align="center"><h3>Add Students</h3></td>
        </tr>
        <tr>
        <td>First Name :</td>
        	<td><input  type="text" id="fname" name="fname" value=""></td>
			<td><div id="r1"></div></td>
	    </tr>
        <tr>
            <td>Last Name:</td>
            <td><input  type="text" id="lname" name="lname" value=""></td>
			
        </tr>
        <tr>
            <td class="login">Email Address:</td>
            <td class="login" ><input  type="text" name="email" id="email" value=""></td>
			<td><div id="r2"></div></td>
			
        </tr>
        <tr>
            <td class="login">Phone:</td>
            <td class="login" ><input  type="text" name="phone" id="phone" value=""></td>
			<td><div id="r3"></div></td>
	     </tr>
        <tr>
            <td class="login">Class:</td>
            <td class="login"><select name="classname" id="classname"><option value="0">Select Class</option>
			<?php
            $query=mysql_query("select * from class");
            while($row=mysql_fetch_array($query))
            {
              echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
			?>
            </select>
            </td>
		 </tr>
        <tr><td class="login">Roll No.:</td>
		<td class="login"><input type="text" name="rollno" id="rollno" value=""></td>
		<td><div id="r4"></div></td>
		</tr>
        <tr><td class="login">Branch:</td>
		<td class="login"><input type="text" name="branch" id="branch" value=""></td>
		</tr>
        <tr><td class="login">Gaurdian/ Parents Contact No.:</td>
		<td class="login"><input type="text" name="parentsno" id="parentsno" value=""></td>
		<td><div id="r5"></div></td>
		</tr>
        <tr>
       	 <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" colspan="2" align="left">
        	<input type="submit" value="SUBMIT" name="addstudent" id="addstudent" onclick="return  checkstudents();"/>&nbsp;</td>
        </tr>
    </table>
</form>
