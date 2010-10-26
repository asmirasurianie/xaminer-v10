<?php
include('includes/connect.php');
//require('includes/top.php');
    	$strFName = $_REQUEST["fname"];
		$strLName = $_REQUEST["lname"];
		$strEmail = $_REQUEST["email"];
		$strPhone = $_REQUEST["phone"];
		$strClass = $_REQUEST["classname"];
		$strRollno = $_REQUEST["rollno"];
		$strBranch = $_REQUEST["branch"];
		$strParentsno = $_REQUEST["parentsno"];
		$r = '';
		for($j=0; $j<5; $j++)
			$r .= chr(rand(0, 25) + ord('1'));

//$sql1="select * from users where user_id='1'";
//$result1=mysql_query($sql1);
		
//$row1=mysql_fetch_array($result1);


$std="select * from students where email='".$strEmail."'";
$stdResult=mysql_query($std);

if(mysql_num_rows($stdResult)>0)

		  {
			 header("location:index.php#students");
		  } 

		  else
				{				

$sql="INSERT INTO students(first_name, last_name, email, phone_no,class_id,rollno,branch, parentsno,username,password,confirm) VALUES ('$strFName', '$strLName', '$strEmail', '$strPhone', '$strClass','$strRollno','$strBranch','$strParentsno','$strFName','$r','1')";
$result=mysql_query($sql);

				}

   // recipients
$to  = $strEmail; 
$cc = $row1['email_id'];
// subject
$subject = 'Students Details';
// message
$message = 'This is your username:'.$strFName.'<br/>Password:'.$r;

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To:' . $to . "\r\n";
$headers .= 'Cc:' . $cc . "\r\n";
$headers .= 'From: no-reply@catseyetech.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);

header("location:index.php#students");
?>