<? ob_start(); ?>
<?php
  session_start(); 
  include('../includes/connect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Xaminer</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div id="header">
			<TABLE width="100%" height="70%" border="0">				
                <TR>
                	<TD align="left" style="font-size: 11px; vertical-align:middle">
                    <img src="images/xaminer_logo.png">
					</TD>
					<TD align="right" style="font-size: 11px; vertical-align:middle">
                    <a href="logoff.php">Logout</a> &nbsp;<a href="index.php">Back</a>
					</TD>
				</TR>
			</TABLE>
        </div>  
<div style="width:900px;">
<?php
//echo $_POST['Text1'];

$date=date('d-n-Y');
$attended_time=$_POST['attended_time'];
$tt=$_POST['Text1'];
$paper_id= $_POST['paper_id'];

$count=$_POST['count'];
for($i=1;$i<=$count;$i++)
	    {
			//echo "options".$i;
			
		  $Questions_ID=$_POST["questions".$i];
		  $Options_ID=$_POST["options".$i];
						

$sql1="Select ques.marks from questions as ques,answers as ans,options as opt where ques.questions_id=ans.questions_id and opt.options_id=ans.options_id and ans.questions_id='".$Questions_ID."'and ans.options_id='".$Options_ID."'";
$result1=mysql_query($sql1);
	if(mysql_num_rows($result1) >0){
		
	
		while($row=mysql_fetch_array($result1))
				  {					
					$totalmarks=$totalmarks +$row[0];
					
				  }
	}
				
	else {
			$totalmarks ='0';
			
	}																																	
			
						
		  }	
	
	
	$sql2="INSERT INTO class_std(`std_id`,`paper_id`,`totalmarks`,`attended_date`,`attended_time`,`total_time(in seconds)`)VALUES('".$_SESSION['student_id']."','$paper_id','$totalmarks','$date','$attended_time','$tt')";

	$result2=mysql_query($sql2);
	
	$sql4 =mysql_query("Select * from students where std_id=".$_SESSION['student_id']);
	$re4=mysql_fetch_array($sql4);
	
	$sql5 =mysql_query("Select * from paper_time where paper_id='".$paper_id."'");
	$re5=mysql_fetch_array($sql5);
	
	$sql6 =mysql_query("Select * from papers where paper_id='".$paper_id."'");
	$re6=mysql_fetch_array($sql6);
	
	if($result2) {
		//echo 'date'.$re5["date"].'<br>';
	
	
		$ch = curl_init('http://122.166.5.17/desk2web/SendSMS.aspx?UserName=asian&password=export1557&MobileNo='.$re4["parentsno"].'&SenderID=xaminer&CDMAHeader=xxxx&Message=Dear+parents,+'.$re4["first_name"].'+has+scored+'.$totalmarks.'+marks+out+of+'.$re6["outof"].'+in+exam+scheduled+on+'.$re5["date"].'&isFlash=xxxx'); //load the urls
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); //No need to wait for it to load. Execute it and go.
            curl_exec($ch); //Execute
            curl_close($ch); //Close it off
		header('Location:index.php#attendschedule');
		
	}
	
?>
</div>
</body>
</html>
<? ob_flush(); ?>