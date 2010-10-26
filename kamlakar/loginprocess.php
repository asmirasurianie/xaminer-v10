<? ob_start(); ?>
<head>
<style type="text/css">
<!--
#cd {
	margin: auto;
	height: 50px;
	width: 450px;
	font-family: "Courier New", Courier, mono;
	font-size: 24pt;
	color: #000;
	text-align: center;
	font-weight: bold;
	background-image: url(back.jpg);
	vertical-align: middle;
}
-->
</style>
</head>
<?php
session_start();
include('../includes/connect.php');
$user = $_POST['username'];
$password = $_POST['password'];
//echo $password ;

$query  = "SELECT * FROM students where username='".trim($user)."'";
$result = mysql_query($query);

if(mysql_num_rows($result)!="")
{ 
while($row = mysql_fetch_assoc($result))
{

     if(trim($password)==trim($row['password']))
      { 
			$_SESSION['student_id']= $row['std_id'];
			$_SESSION['first_name']= $row['first_name'];
			$_SESSION['last_name']= $row['last_name'];
			$_SESSION['email']= $row['email'];
			$_SESSION['phone_no']= $row['phone_no'];
			$_SESSION['class_id']=$row['class_id'];
			$_SESSION['rollno']=$row['rollno'];
			$_SESSION['branch']=$row['branch'];
			$_SESSION['parentsno']=$row['parentsno'];
			$_SESSION['username']=$row['username'];
			$_SESSION['password']=$row['password'];

  
   //header('location:generatepaper1.php?papername='.$re2[0]);
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
<? ob_flush(); ?>