<?php
session_start();
//echo '<pre>';
//print_r($_SESSION);
if(isset($_SESSION['username']))
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Xaminer</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script language="javascript" src="../js/common.js"></script>
</head>
<body>

            <form name="chkpassfrm" action="change_process.php" method="post">
              <table border="0" width="100%" cellspacing="3" cellpadding="2" align="center" summary="Password Forgoten Table">
                <tr>
                  <td colspan="2" height="10">
                    </td>
                </tr>
              </table>
              <table   border="0" width="50%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
                <tr>
                  <td class="login">Enter your current password :</td>
                  <td class="login"><input  type="password" id="currentpass" name="currentpass" value=""></td>
                </tr>
                <tr>
                  <td class="login">Enter New password :</td>
                  <td class="login"> <input  type="password" name="newpass" id="newpass" value=""></td>
                </tr>
				 <tr>
                  <td class="login">Confirm your new password :</td>
                  <td class="login"> <input  type="password" name="confirmpass" id="confirmpass" value=""></td>
                </tr>
				<tr>
				<td>&nbsp;</td>
				</tr>
                <tr>
                  <td>&nbsp;</td>
                  <td valign="top" align="left">
				   <input type="submit" value="SUBMIT" name="submit"/>
                    &nbsp;</td>
                </tr>
              </table>
            </form>
 
      
</body>
</html>
<?php } else {
header('Location:index.php');
}
?>