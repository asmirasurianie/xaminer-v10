<html>
<head>
<link rel="stylesheet" href="css/style.css" type="text/css" media="print, projection, screen">
</head>
<body>
<table align="center" border="0" width="80%" height="100%">
	<tr>
		<td align="center" class="smallText" width="50%">
			<A HREF="/"><IMG SRC="images/logo.jpg" WIDTH="140" HEIGHT="54" BORDER="0" ALT=""> <br/></A>
			academic performance analyser
		</td>
		<td align="center" style="vertical-align: middle" width="1%">
			<IMG SRC="images/blacDot.png" WIDTH="1" HEIGHT="400px" BORDER="0" ALT="">
		</td>
		<td align="center">
			<form name="login" action="loginprocess.php" method="post">
				<table border="0" cellspacing="2" cellpadding="2" class="loginTable" >
					<tr class="main">
						<td rowspan="4" width="100px" align="center"><IMG SRC="images/login.png" WIDTH="48" HEIGHT="48" BORDER="0" ALT=""></td>
						<td colspan="2" align="center" class="errorText"><img src="images/pixel_black.gif" border="0" alt="" width="100%" height="1">
							<b>
								<?php
								if($_REQUEST['er']==2) {
									echo '<b style="color:red;">Invalid Username</b>';
								} elseif($_REQUEST['er']==1) {
									echo '<b style="color:red;">Invalid Password</b>';
								}
								?>
							</b>
						</td>
					</tr>
					<tr height="10px">
						<td align="right"><label for="username">Username : </label></td>
						<td><input type="text" name="username" size="20" class="textBox"></td>
					</tr>
					<tr height="10px">
						<td align="right"><label for="password">Password : </label></td>
						<td><input type="password" name="password" maxlength="40" class="textBox" size="20"></td>
					</tr>
					<tr height="10px">
						<td>&nbsp;</td>
						<td><input type="submit" name="Submit" value="SUBMIT" onClick="return validate();" class="sub-butt"/></td>
					</tr>
					<tr>
						<td colspan="3" class="smallerText" style="padding-left:10px;padding-right:10px" align="center">[This site is SSL secured. Please enter a valid username and password. Site will be locked after 3 incorrect attempts for 3 hours before you can try again]</td>
					</tr>
					<tr>
						<td></td>
						<td><!--<a href="password_forgotten.php"><b>Password forgotten?</b></a>--></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr height="10%">
		<td colspan="3" align="center">
			<TABLE width="100%">
				<TR align="center" class="smallerText">
					<TD><IMG SRC="images/res.png" WIDTH="32" HEIGHT="32" BORDER="0" ALT=""><br/>manage</TD>
					<TD><IMG SRC="images/sched1.png" WIDTH="32" HEIGHT="32" BORDER="0" ALT=""><br/>schedule</TD>
					<TD><IMG SRC="images/scanner.png" WIDTH="32" HEIGHT="32" BORDER="0" ALT=""><br/>OCR</TD>
					<TD><IMG SRC="images/rep.png" WIDTH="32" HEIGHT="32" BORDER="0" ALT=""><br/>reports</TD>
					<TD><IMG SRC="images/mobile.png" WIDTH="32" HEIGHT="32" BORDER="0" ALT=""><br/>mobile</TD>
					<TD><IMG SRC="images/secure.png" WIDTH="32" HEIGHT="32" BORDER="0" ALT=""><br/>secure</TD>
				</TR>
			</TABLE>
		</td>
	</tr>
	<tr height="1%">
		<td colspan="3">
			<hr/>
		</td>
	</tr>
	<tr height="1%" class="smallerText">
		<td align="center" colspan="3">
			online exams | mobile exams | sms alerts | instant verification | period analysis report | OCR question banks | OCR paper correction
		</td>
	</tr>
</table>
</body>
</html>