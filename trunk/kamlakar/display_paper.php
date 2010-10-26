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
                    <a href="logoff.php">Logout</a>
					</TD>
				</TR>
			</TABLE>
        </div>  
<div style="width:900px;">
<table border="0" width="100%">
<form name="answers" action="exams_process.php" method="post">
<?php 

$date= date("d-m-Y"); 

$ltime =time() + 5.50*60*60 ;
$mytime =date('g:i',$ltime);

$paper_name= $_REQUEST['paper_name'];

 $time="select * from paper_time where paper_name='".$paper_name."'";
	   $seltime=mysql_query($time);
	   $rr=mysql_fetch_array($seltime);
	   if($date==$rr['date'])
		   {
			   echo '<tr><td colspan="2" align="center" style="text-transform:uppercase; color:#f00;">'.$paper_name.'</td></tr>';
$sql = mysql_query("select * from questionpapers,questions where questionpapers.questions_id=questions.questions_id and questionpapers.paper_name='".$paper_name."'");
				if(mysql_num_rows($sql) >0)
				{
					$i=1;
					while($row= mysql_fetch_array($sql))
					{ 
						echo '<tr><td  valign="top" colspan="2"><div id="disquestions">'.$i.')&nbsp;'.$row['questions'].'<input type="hidden" name="questions[]" value="'.$row['questions_id'].'"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;['.$row['marks'].']</div><div style="background:url(images/paper_03.jpg); height:27px;"></div></td></tr><tr><td colspan="2"><table border="0" cellspacing="5px">';
						$sql1= mysql_query("select * from options where questions_id=".$row['questions_id']);
						while($rowopt= mysql_fetch_array($sql1))
							{
								echo '<tr><td><input type="checkbox" name="options[]" id="options[]" class="options" value="'.$rowopt['options_id'].'"></td><td>'.$rowopt['options'].'</td></tr>';
							}
						echo '</table></td></tr>';
						$i++;
					}
				echo '<tr><td><input type="hidden" value="'.$paper_name.'" name="paper" id="paper"/><input type="submit" value="submit" name="submit" /></td></tr>';
				}
				
		   }
		  else
				{
					echo "<br><br><p><b>Please check the date on which paper was scheduled</b></p>";
				}    

?>
</form>
</table>
</div>
</body>
</html>
<? ob_flush(); ?>