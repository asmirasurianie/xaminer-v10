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
<div style="width:900px;margin-left:40px;">
<table border="0" width="100%" class="papertable">
<?php
include('includes/connect.php');
$paper_id= trim($_REQUEST['paper_id']);
$sq = mysql_query("select * from papers where paper_id=".$paper_id);
$rs =mysql_fetch_array($sq);

echo '<tr><td colspan="2" align="center" style="text-transform:uppercase; color:#f00;">'.$rs["paper_name"].'</td></tr>';
$sql = mysql_query("select * from questionpapers,questions where questionpapers.questions_id=questions.questions_id and questionpapers.paper_id=".$rs['paper_id']);
if(mysql_num_rows($sql) >0)
{
	$i=1;
	while($row= mysql_fetch_array($sql))
	{ 
		echo '<tr><td  valign="top" colspan="2"><div id="disquestions"><table border="0"><tr><td valign="top">'.$i.')</td><td valign="top">'.$row['questions'].'</td>';
		if($row['ques_path']!='')
		{
			echo '<td><img src="'.$row['ques_path'].'"></td>';
		}		
		echo '<td valign="top">['.$row['marks'].']</td></tr></table></div><div style="background:url(images/paper_03.jpg); height:27px;"></div></td></tr><tr><td></td><td><table border="0" cellspacing="5px">';
		$sql1= mysql_query("select * from options where questions_id=".$row['questions_id']);
		while($rowopt= mysql_fetch_array($sql1))
			{ 
				if($rowopt['opt_path']=="")
				{
				echo '<tr><td><input type="radio" name="options'.$i.'" id="options'.$i.'" class="options"></td><td>'.$rowopt['options'].'</td></tr>';
				}
				else
				{
				echo '<tr><td><input type="radio" name="options'.$i.'" id="options'.$i.'" class="options"></td><td>'.$rowopt['options'].'&nbsp;&nbsp;<img src="'.$rowopt['opt_path'].'"></td></tr>';	
				}
			}
		echo '</table></td></tr>';
		$i++;
	}
}

?>
</table>
</div>
</body>
</html>