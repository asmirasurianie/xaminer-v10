<meta http-equiv="refresh" content="2;index.php">
<table border="0" width="100%" cellspacing="3" cellpadding="2" align="center">
  <tr>
    <td colspan="2" align="center" height="150"><b>
      <?php
	 if($_REQUEST['upacc']==1)
	{
	echo '<h2>You have Updated your login information . Please Login Again</h2>';
	}else
	{
	echo '<h2>You are successfully Logged Off.</h2>';
	}
	 ?>
      </b></td>
  </tr>
</table>
