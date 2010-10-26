<? ob_start(); ?>
<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['user_firstname']);
unset($_SESSION['user_lastname']);
unset($_SESSION['email_id']);
unset($_SESSION['phone_no']);
unset($_SESSION['username']);
unset($_SESSION['password']);
@session_destroy();

?>
<table width="100%"  border="0" cellpadding="2" cellspacing="2"  > 
  <tr class="main">
    <td colspan="2" align="center" class="errorText"><img src="images/pixel_black.gif" border="0" alt="" width="100%" height="1"><b>&nbsp;</td>
  </tr>
  </table>
<table align="center" width="50%" height="100"  border="0" cellspacing="0" cellpadding="0" summary="Login Table" >
        <tr>
          <td><fieldset style="height:150px;">
            <legend>Log Off:</legend>
            <img src="images/pixel_trans.gif" border="0" alt="" width="100%" height="5">
              <table border="0" width="100%" cellspacing="3" cellpadding="2" align="center" summary="Password Forgoten Table">
                <tr>
                  <td colspan="2"><img src="images/pixel_trans.gif" border="0" alt="" width="100%" height="10">
                    </td>
                </tr>
              </table>
			  
			  
              <table border="0" width="100%" cellspacing="3" cellpadding="2" align="center" summary="Password Forgoten Table">
                <tr>
                  <td class="login" colspan="2" align="center"><b><?php
	 if($_REQUEST['upacc']==1)
	{
	echo 'You are Updated your login information . Please Login Again';
	}else
	{
	header('Location:index.php');
	}
	 ?></b></td>
                </tr>
                 
              </table>
            </fieldset></td>
        </tr>
       </table>
       <? ob_flush(); ?>