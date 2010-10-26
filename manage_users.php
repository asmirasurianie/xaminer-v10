<?php
session_start();
include('includes/connect.php');
?>


<script type="text/javascript">
 $(document).ready(function(){
  $("#adduser").click(function(){
  $('#adduserform').load('adduser.php');
  });
}); 
</script>
<div id="loadmessage"></div>
<div>
    <b style="font-size:15px; color:#900">Manage Users</b><br /><br />
    <?php $sql = mysql_query("select * from users where users_id!='1'");
    if(mysql_num_rows($sql) >0){
    echo '<table border=0 cellspacing="2px" cellpadding="0px"  width="70%">';
    echo '<tr class="tableheader"><th><b>'.'First Name'.'</b></th>'.'<th><b>'.'Last Name'.'</b></th>'.'<th><b>'.'Email Id'.'</b></th>'.'<th><b>'.'User Name'.'</b></th>'.'<th><b>'.'Password'.'</b></th>'.'<th><b>'.'Date Created'.'</b></th>'.'<th><b>'.'Edit'.'</b></th>'.'<th><b>'.'Delete'.'</b></th></tr>';
    while($row= mysql_fetch_array($sql))
    {
    
    echo '<tr><td>'.$row['user_firstname'].'</td>'.'<td>'.$row['user_lastname'].'</td>'.'<td>'.$row['email_id'].'</td>'.'<td>'.$row['username'].'</td>'.'<td>'.$row['password'].'</td>'.'<td>'.$row['user_created'].'</td>'.'<td><a href="edit.php?uid='.$row['users_id'].'"><input type="button" value="EDIT" name="Edit" class="submit-butt"/></a></td>'.'<td><a href="delete.php?uid='.$row['users_id'].'">';?>
    <input type="button" value="DELETE" name="delete" onclick="javascript:if(confirm('Are you sure you want to delete this user?')) return true; else return false;" class="submit-butt" /></a>
    <?php
    echo '</td></tr>';
    }
    echo '</table>';
    }
    else
    {
    echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
    echo '<tr><td>No User Found</td></tr>';
    echo '</table>';
    }
    ?>
    <br>
    <input type="button" id="adduser" name="adduser" value="ADD USER" class="submit-butt">
<div>
 <div id="loading"></div>
<hr />

<div id="adduserform">
</div>
