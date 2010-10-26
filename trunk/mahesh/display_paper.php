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
		<link type="text/css" rel="stylesheet" href="css/styles.css" />
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.pajinate.js"></script>
		
		<script type="text/javascript">
			
			$(document).ready(function(){
				$('#paging_container7').pajinate({
					num_page_links_to_display : 3,
					items_per_page : 1	
				});
			});										
		</script>

</head>
<body>
<div id="header">
			<TABLE width="100%" height="70%" border="0">				
                <TR>
                	<TD align="left" style="font-size: 11px; vertical-align:middle">
                    	<img src="images/mt_logo.gif">
					</TD>
                    <TD align="left" style="vertical-align:top">
                    	<img src="images/xaminer_logo.png">
					</TD> 
					<TD align="right" style="font-size: 11px; vertical-align:middle">
                    	<a href="logoff.php">Logout</a>
					</TD>
				</TR>
			</TABLE>
        </div>  
<div style="width:900px;margin-left:40px;">

<form name="answers" action="exams_process.php" method="post">
	<?php 			
	include('../includes/connect.php'); 
	$attended_time=date("H:i:s");
    $sql = mysql_query("select * from questions");
	$date= date("d-m-Y"); 
	$ltime =time() + 5.50*60*60 ;
	$mytime =date('g:i',$ltime);
	$paper_id= $_REQUEST['paper_id'];
	$sq = mysql_query("select * from papers where paper_id=".$paper_id);
	$rs =mysql_fetch_array($sq);
	$time="select * from paper_time where paper_id='".$paper_id."'";
	$seltime=mysql_query($time);
	$rr=mysql_fetch_array($seltime);
	
	//date wise display
	if(($date==$rr['date'] and $rr['all_time']=="no") or ($rr['date']=="" and $rr['all_time']=="yes") or ($rr['date']!="" and $rr['all_time']=="yes"))
		{
			if($rr['one_question']=="Yes")
		  		{
			echo '<div style="text-align:center;color:red;text-transform: uppercase;">'.$rs["paper_name"].'</div>';
	$sql = mysql_query("select * from questionpapers,questions where questionpapers.questions_id=questions.questions_id and questionpapers.paper_id=".$paper_id);
	if(mysql_num_rows($sql) >0)
				{
					$i=1;					
    ?>	
        
        <div id="paging_container7" class="container">			
            <div class="page_navigation"></div>
                <ul class="content">
                <?php              
                while($row= mysql_fetch_array($sql))					 
                {
					
                echo '<li><div id="disquestions"><table border="0"><tr><td valign="top">'.$i.')</td><td valign="top">'.$row['questions'].'<input type="hidden" name="questions'.$i.'" value="'.$row['questions_id'].'"; ?></td>';
					if($row['ques_path']=="")
						{
						echo '<td><img src="../'.$row['ques_path'].'"></td>';
						}
						echo '<td valign="top">['.$row['marks'].']</td></tr><tr><td colspan="4"><table border="0">';
						
						$sql1= mysql_query("select * from options where questions_id=".$row['questions_id']);
						while($rowopt= mysql_fetch_array($sql1))
							{	
								if($rowopt['opt_path']=="")
									{
										echo '<tr><td><input type="radio" name="options'.$i.'" id="options'.$i.'" class="options" value="'.$rowopt['options_id'].'"></td><td>'.$rowopt['options'].'</td></tr>';				}
									else
									{									
								echo '<tr><td><input type="radio" name="options'.$i.'" id="options'.$i.'" class="options" value="'.$rowopt['options_id'].'"></td><td>'.$rowopt['options'].'&nbsp;&nbsp;<img src="../'.$rowopt['opt_path'].'"></td></tr>';
									}
							}
						echo '</table></td></tr></table></div>';
						echo '</table></td></tr>';
						$i++;
                }
                ?>
                </ul>	
            </div>										
        </div>
    <?php 
	echo '<div style="text-align:right;"><input type="hidden" value="'.$paper_id.'" name="paper_id" id="paper_id"/><input type="submit" value="submit" name="submit" /></div>';
					}
				}
				else { //else start
					echo '<tr><td colspan="2" align="center" style="text-transform:uppercase; color:#f00;"><div style="text-align:center;color:red;text-transform: uppercase;">'.$rs["paper_name"].'</div></td></tr>';
$sql = mysql_query("select * from questionpapers,questions where questionpapers.questions_id=questions.questions_id and questionpapers.paper_id=".$paper_id);

$row_count=mysql_num_rows($sql);
//echo $row_count;			
	
		if(mysql_num_rows($sql) >0)
				{
					$i=1;
					while($row= mysql_fetch_array($sql))
					{ 
						echo '<tr><td  valign="top" colspan="2"><div id="disquestions"><table border="0"><tr><td valign="top">'.$i.')</td><td valign="top">'.$row['questions'].'<input type="hidden" name="questions'.$i.'" value="'.$row['questions_id'].'"; ?></td>';
						if($row['ques_path']=="")
						{
						echo '<td><img src="../'.$row['ques_path'].'"></td>';
						}
						echo '<td valign="top">['.$row['marks'].']</td></tr></table></div><div style="background:url(images/paper_03.jpg); height:27px;"></div></td></tr><tr><td colspan="2"><table border="0" cellspacing="5px">';
						$sql1= mysql_query("select * from options where questions_id=".$row['questions_id']);
						while($rowopt= mysql_fetch_array($sql1))
							{
								if($rowopt['opt_path']==" ")
									{
										echo '<tr><td><input type="radio" name="options'.$i.'" id="options'.$i.'" class="options" value="'.$rowopt['options_id'].'"></td><td>'.$rowopt['options'].'</td></tr>';				}
									else
									{									
								echo '<tr><td><input type="radio" name="options'.$i.'" id="options'.$i.'" class="options" value="'.$rowopt['options_id'].'"></td><td>'.$rowopt['options'].'&nbsp;&nbsp;<img src="../'.$rowopt['opt_path'].'"></td></tr>';
									}
							}
						echo '</table></td></tr>';
						$i++;
					}
				echo '<tr><td><div style="text-align:right;"><input type="hidden" value="'.$row_count.'" name="count" id="count"/><input type="hidden" value="'.$paper_id.'" name="paper_id" id="paper_id"/><input type="hidden" value="'.$attended_time.'" name="attended_time" id="attended_time"/><input type="submit" value="submit" name="submit" /></div></td></tr>';
				} 
				} //else end
	}
	
	?>
	<script>
    $(document).ready(function(){
    $('li:odd, .content > *:odd').css('background-color','#FFD9BF');
    });
    </script>
</form>

</div>
	</body>
</html>