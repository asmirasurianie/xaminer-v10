<? ob_start(); ?>
<?php
include('includes/connect.php');
session_start();
//require('includes/top.php');
if(isset($_POST['Submit'])=="SUBMIT")
{

$date=$_POST["doc"];
$shour=$_POST['shours'];
$sminutes=$_POST['sminutes'];
$ehour=$_POST['ehours'];
$eminutes=$_POST['eminutes'];
$paper_name=$_POST['paper'];
  if(@$_POST['a1'])
     {
	   $allt='yes';
	 }
	else
	{
	  $allt='no';
	} 
  
  if(@$_POST['a2'])
    {
	  $oneq='yes';
	}
	else
	{
	  $oneq='no';
	}
   
$start_time=$shour.":".$sminutes;
$end_time=$ehour.":".$eminutes;

$sql3 = mysql_query("SELECT ques.class_id FROM questionpapers as qp, questions as ques where ques.questions_id=qp.questions_id and paper_id='".trim($paper_name)."'");

$row3= mysql_fetch_array($sql3);
$class_id=$row3['class_id'];

if($date=="")
{
$sql=mysql_query("Select * from paper_time where date='".$date."'and start_time='".$start_time."' or date='".$date."'and end_time='".$end_time."' and paper_id='".$paper_name."'");
$result1=mysql_fetch_row($sql);

if(mysql_num_rows($sql))
{
	header("location:addexamscheduler.php?er=1");	
}
elseif($start_time>$result1[1] && $end_time<$result1[2])
 {
   header("location:addexamscheduler.php?er=1");	
 }
else
	{
	$dt="INSERT INTO paper_time(`date`,`one_question`,`start_time`,`end_time`,`paper_id`,`all_time`)VALUES('$date','$oneq','$start_time','$end_time','$paper_name','$allt')";
	
	$dt_result=mysql_query($dt);
	
	if($dt_result)
		{							 
		$paper="INSERT INTO temp_std(`class_id`,`paper_id`)VALUES('$class_id','$paper_name')";
		$paper_result=mysql_query($paper);	
		if($paper_result)
		{
			$sql1="select * from students where class_id=".$class_id;
			$res=mysql_query($sql1);
		
			while($ro=mysql_fetch_array($res))
			{	
			$total=0;
				$qs=mysql_query("select * from questions as ques, questionpapers as qp where ques.questions_id=qp.questions_id and qp.paper_id='".$paper_name."'");
				while($rq=mysql_fetch_array($qs))
				{
					$total=$total+$rq['marks'];
				}
				$paperstd="INSERT INTO class_std(`std_id`,`paper_id`,`outof`)VALUES('$ro[0]','$paper_name','$total')";				
				$std_result=mysql_query($paperstd);	
				if($std_result)
				{
					
					$ch = curl_init('http://122.166.5.17/desk2web/SendSMS.aspx?UserName=asian&password=export1557&MobileNo='.$ro["phone_no"].'&SenderID=xaminer&CDMAHeader=xxxx&Message=Dear+'.$ro["first_name"].'+You+have+an+exam+scheduled+for+'.$date.'+at+'.$start_time.'&isFlash=xxxx'); //load the urls
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); //No need to wait for it to load. Execute it and go.
            curl_exec($ch); //Execute
            curl_close($ch); //Close it off
				header("Location:index.php#scheduler");
				}
				else {
					//header("Location:index.php#scheduler");
				}
				
			}
			
		}
		else
		{
		//header("location:index.php#scheduler");
		}	
	}
   }
   header("location:index.php#scheduler");	
 }
   //added by bhavika
  else
  {
              
	$dt="INSERT INTO paper_time(`date`,`one_question`,`start_time`,`end_time`,`paper_id`,`all_time`)VALUES('$date','$oneq','$start_time','$end_time','$paper_name','$allt')";
	
	$dt_result=mysql_query($dt);
	if($dt_result)
		{							 
		$paper="INSERT INTO temp_std(`class_id`,`paper_id`)VALUES('$class_id','$paper_name')";
		$paper_result=mysql_query($paper);	
		if($paper_result)
		{
			$sql1="select * from students where class_id=".$class_id;
			$res=mysql_query($sql1);
		
			while($ro=mysql_fetch_array($res))
			{	
			$total=0;
				$qs=mysql_query("select * from questions as ques, questionpapers as qp where ques.questions_id=qp.questions_id and qp.paper_id='".$paper_name."'");
				while($rq=mysql_fetch_array($qs))
				{
					$total=$total+$rq['marks'];
				}
				$paperstd="INSERT INTO class_std(`std_id`,`paper_id`,`outof`)VALUES('$ro[0]','$paper_name','$total')";				
				$std_result=mysql_query($paperstd);	
				if($std_result)
				{
					
					$ch = curl_init('http://122.166.5.17/desk2web/SendSMS.aspx?UserName=asian&password=export1557&MobileNo='.$ro["phone_no"].'&SenderID=xaminer&CDMAHeader=xxxx&Message=Dear+'.$ro["first_name"].'+You+have+an+exam+scheduled+for+'.$date.'+at+'.$start_time.'&isFlash=xxxx'); //load the urls
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); //No need to wait for it to load. Execute it and go.
            curl_exec($ch); //Execute
            curl_close($ch); //Close it off
				header("Location:index.php#scheduler");
				}
				else {
					//header("Location:index.php#scheduler");
				}
				
			}
			
		}
		else
		{
		//header("location:index.php#scheduler");
		}	
	}
      header("location:index.php#scheduler");
  }
}	
?>
<? ob_flush(); ?> 