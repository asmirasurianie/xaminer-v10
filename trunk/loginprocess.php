<?php
session_start();
include('includes/connect.php');
$user = $_POST['username'];
$password = $_POST['password'];

$query  = "SELECT * FROM users where username='".trim($user)."'";
$result = mysql_query($query);
if(mysql_num_rows($result)!="")
{ 
while($row = mysql_fetch_assoc($result))
{

if(trim($password)==trim($row['password']))
{ 
$_SESSION['users_id']= $row['users_id'];
$_SESSION['user_firstname']= $row['user_firstname'];
$_SESSION['user_lastname']= $row['user_lastname'];
$_SESSION['email_id']= $row['email_id'];
$_SESSION['phone_no']= $row['phone_no'];
$_SESSION['username']= $row['username'];
$_SESSION['password']= $row['password'];


 header('Location:index.php'); 
 } 
 else
 { 
 header('Location:login.php?er=1');
 }
 }  
}
else
{ 
header('Location:login.php?er=2');
}

?>