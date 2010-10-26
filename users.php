<table cellpadding="2" cellspacing="2">
  <tr class="main">
    <td colspan="2" align="center" class="errorText">&nbsp;</td>
  </tr>
  </table>


<table width="90%"  border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>

</td>

    <td valign="top">
	
      
    
     <table width="95%" align="center"  border="0" cellspacing="0" cellpadding="0" summary="Table holding Store Information">
         <tr valign="top">
          <td width="100%"><fieldset>
            <legend> Admin Info</legend>
            <ul>
              <li>First Name : <?php echo $_SESSION['user_firstname'];?> </li>
<br>             <li>Last Name : <?php echo $_SESSION['user_lastname'];?> </li>
<br>
<li>User Name : <?php echo $_SESSION['username'];?> </li>
<br>
<li>Password : <?php echo $_SESSION['password'];?> </li>

<?php /* $sql = mysql_query("select * from users where username='".trim($_SESSION['username'])."'");
if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);
if($row['users_id']==1)
{
?>
<br>
<br>

<?php }} ; */?>
<a href="editadmin.php?uid=<?php echo $_SESSION['users_id'];?>"><input type="button" value="EDIT" name="Edit" /></a>
            </ul>
            </fieldset>
      </td>
       </tr>
      </table>
             </td>
  </tr>
</table>
