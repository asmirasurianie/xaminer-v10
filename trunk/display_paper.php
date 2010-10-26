<?php
  session_start(); 
  include('includes/connect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Xaminer</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div style="width:900px;">
<table border="0" width="100%">
<form name="answers" action="exams_process.php" method="post">
<?php
 $q2=mysql_query("SELECT Distinct(paper_name) from temp_std WHERE std_id = '".$_SESSION['student_id']."'");
 while($rowq=mysql_fetch_array($q2))
 {
 
$paper_name= $rowq[0];

echo '<tr><td colspan="2" align="center" style="text-transform:uppercase; color:#f00;">'.$paper_name.'</td></tr>';
$sql = mysql_query("select * from questionpapers,questions where questionpapers.questions_id=questions.questions_id and questionpapers.paper_name='".$paper_name."'");
if(mysql_num_rows($sql) >0)
{
	$i=1;
	while($row= mysql_fetch_array($sql))
	{ 
		echo '<tr><td  valign="top" colspan="2"><div id="disquestions">'.$i.')&nbsp;'.$row['questions'].'<input type="hidden" name="questions[]" value="'.$row['questions_id'].'"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;['.$row['marks'].']</div><div style="background:url(images/paper_03.jpg); height:27px;"></div></td></tr><tr><td></td><td><table border="0" cellspacing="5px">';
		$sql1= mysql_query("select * from options where questions_id=".$row['questions_id']);
		while($rowopt= mysql_fetch_array($sql1))
			{
				echo '<tr><td><input type="checkbox" name="options[]" id="options[]" class="options" value="'.$rowopt['options_id'].'"></td><td>'.$rowopt['options'].'</td></tr>';
			}
		echo '</table></td></tr>';
		$i++;
	}
}
}

   /*$re1=mysql_query($q2);
   $re2=mysql_fetch_row($re1);
       $time="select * from paper_time where paper_name='".$re2[0]."'";
	   $seltime=mysql_query($time);
	   $displaytime=mysql_fetch_row($seltime);
	   $date=$displaytime[0];
	   $starttime=$displaytime[1];
	   
	   $min=explode(':',$starttime);
	
	    	   
	    //set the time according to asia/calcutta 
			$ltime =time() + 5.50*60*60 ;
			$mytime =date('g:i:s',$ltime);
			
		//at exaction where where timer should start
			      $event_length=5;
                  $timestamp = strtotime("$starttime");
                  $etime = strtotime("-$event_length minutes", $timestamp);
                  $next_time = date('g:i:s', $etime);
				  
				  $min2=explode(':',$next_time);
	
		$sql="select * from questionpapers where paper_name='".$re2[0]."'ORDER BY RAND() ";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		while($row=mysql_fetch_row($result))
			{
		$sql2="select * from  questions where questions_id='".$row[2]."'";
		$result1=mysql_query($sql2);
		$ans=mysql_fetch_row($result1);
		echo $ans[1]."<br/>";
		    $sql3="select * from options where questions_id='".$ans[0]."'";
			$result2=mysql_query($sql3);
			  while($row3=mysql_fetch_row($result2))
			    {
					echo "<input type='checkbox' name='options' id='options' value='".$row3[0]."'/>".$row3[0];
				}
				echo "<br/>";
	}
		
	*/           
?>
<tr><td><input type="submit" value="submit" name="submit" /></td></tr>
</table>
</div>
</body>
</html>