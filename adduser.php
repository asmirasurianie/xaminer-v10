<?php
include('includes/connect.php');
?>
<!--[if ie 8]>
<script src="js/jquery-1.2.3.pack.js"></script>
<script src="js/runonload.js"></script>
<script src="js/tutorial.js"></script>
<![endif]-->
<div id="users_form">
<div id="resultdisplay"></div>
<form name="addusers" id="addusers" method="post" enctype="multipart/form-data" action="adduser_process.php">
    <table  border="0" width="40%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
        <tr>
        	<td colspan="2"><h3>Add New User</h3></td>
        </tr>
        <tr>
            <td class="login">First Name :</td>
            <td class="login"><input  type="text" id="fname" name="fname" value=""></td>
			<td><div id="r1"></div></td>
       </tr>
        <tr>
            <td class="login">Last Name:</td>
            <td class="login"><input  type="text" id="lname" name="lname" value=""></td>
			<td><div id="r2"></div></td>
        </tr>
        <tr>
            <td class="login">Email Address:</td>
            <td class="login" ><input  type="text" name="email" id="email" value=""></td>
			<td><div id="r3"></div></td>
        </tr>
        <tr>
            <td class="login">Branch:</td>
            <td class="login"><input  type="text" name="branch" id="branch" value=""></td>
			<td><div id="r3"></div></td>
        </tr>				
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td><input type="submit" value="SUBMIT" class="sub-butt" id="addusers" onclick="return checkuser();" name="addusers" /></td>
			<td> <input type="button" value="cancel" class="sub-butt" onclick="canceluser();return false;"/></td>
        </tr>
    </table>
</form>
</div>
