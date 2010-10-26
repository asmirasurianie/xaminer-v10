<html>
<head>
<link rel="stylesheet" href="css/style.css" type="text/css" media="print, projection, screen">
</head>
<body>
<table align="center" border="0" height="100%">
	<tr>
		<td align="center" class="smallText">
			<IMG SRC="images/logo.jpg" WIDTH="140" HEIGHT="54" BORDER="0" ALT=""> <br/>
			academic performance analyser tool
		</td>
	</tr>
	<tr height="1%" class="smallerText">
		<td align="center">
			online exams | mobile exams | sms alerts | instant verification | period analysis
		</td>
	</tr>
	<tr height="1%">
		<td>
			<hr/>
		</td>
	</tr>
	<tr height="5%">
		<td>
			<table border="0" cellpadding="2" cellspacing="2" >
				<tr class="main">
				<td colspan="2" align="center" class="errorText"><img src="images/pixel_black.gif" border="0" alt="" width="100%" height="1"><b><?php
				 if($_REQUEST['er']==2)
				{
				echo 'Invalid Username';
				}elseif($_REQUEST['er']==1)
				{
				echo 'Invalid Password';
				}
				 ?></b></td>
			  </tr>
			</table>
		</td>
	</tr>
<tr valign="bottom" height="30%">
<td>		
    <div id="login_top"></div>
 	<div id="login_middle">
    	   <form name="login" action="loginprocess.php" method="post">
        <table border="0" cellspacing="2" cellpadding="2">
            <tr>
                <td><label for="username">UserName:</label></td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" name="password" maxlength="40"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Submit" value="SUBMIT" onClick="return validate();" class="sub-butt"/></td>
            </tr>
            <tr>
                <td></td>
                <td><!--<a href="password_forgotten.php"><b>Password forgotten?</b></a>--></td>
            </tr>
    </table>
    </form>
    </div>
    <div id="login_bottom"></div>     
</td>
</tr>
</table>
</body>
</html>