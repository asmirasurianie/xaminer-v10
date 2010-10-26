<? ob_start(); ?>
<?php
require('includes/connect.php');
    	$strFName = $_REQUEST["fname"];
		$strLName = $_REQUEST["lname"];
		$strEmail = $_REQUEST["email"];
		$strBranch = $_REQUEST["branch"];
		//$strUsername = $_REQUEST["username"];
		//$strPassword = $_REQUEST["password"];
        $date = date("F j, Y, g:i a");
		$r = '';
		for($j=0; $j<5; $j++)
			$r .= chr(rand(0, 25) + ord('1'));
		



$usr="select * from users where email_id='".$strEmail."'";
$usrResult=mysql_query($usr);

if(mysql_num_rows($usrResult)>0)

		  {
			 header("location:index.php#examiner");
		  } 

		  else
				{				


 $sql="INSERT INTO users(`user_firstname`, `user_lastname`, `email_id`, `branch`, `username`,`password`,`user_created`) VALUES ('$strFName', '$strLName', '$strEmail', '$strBranch', '$strFName', '$r' , '$date')";
		//echo $sql;
		$result=mysql_query($sql);

				}

	//$sql1="select * from users where user_id='1'";
//$result1=mysql_query($sql1);
		
//$row1=mysql_fetch_array($result1);

// recipients
$to  = $strEmail; 
$cc = $row1['email_id'];

// subject
$subject = 'Login Details';
// message
$message = 'Please find the following login details<br> username:'.$strUsername.'<br/>Password:'.$strPassword;

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To:' . $to . "\r\n";
$headers .= 'Cc:' . $cc . "\r\n";
$headers .= 'From: no-reply@catseyetech.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);

header("location:index.php#examiner");
?>
<? ob_flush(); ?>