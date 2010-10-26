<? ob_start(); ?>
<?php
session_start();
include('includes/connect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
<!--<a href="javascript:window.print()"><img src="images/printer.jpeg" border="0" /></a>-->
<div style="width:900px;">
<!--<table border="0" width="100%">-->
<!--<tr><td colspan="7" align="center" style=" font-size:14px; font-weight:bold;"><?php echo $_POST['papername']; ?></td></tr>-->
<?php
$class_id= $_POST['classname'];
$category_id= $_POST['categoryname'];

$sq2="insert into papers(`paper_name`,`outof`) values ('".$_POST['papername']."','0')";
$sq3=mysql_query($sq2);

																	
$sr=mysql_query("select * from papers where `paper_name`='".$_POST['papername']."'");	
$ro=mysql_fetch_array($sr);
$paper_id=$ro['paper_id'];

if($ro['paper_id']!="")
{ 
	
if(isset($_POST["marks"]) && !empty($_POST["marks"])){	
						//echo "hhh";
						  $Marks=array_values($_POST["marks"]);
						  $QuestionMark=array_values($_POST["question_mark"]);								
						  $count=sizeof($Marks);
						 
						  for($i=0;$i<=$count;$i++){							  
							if(trim($Marks[$i])!=''){								
								$Marks1=addslashes(trim($Marks[$i]));
								
								$Question_Mark=addslashes(trim($QuestionMark[$i]));								
	
									if($_POST['categoryname']=='0')
									{										
									
									$s="select * from questions where `marks`=$Marks1 and class_id=$class_id ORDER BY RAND() limit $Question_Mark";
									$s_re=mysql_query($s);
				
									while($row=mysql_fetch_array($s_re))
													{
					
					
											$q2="insert into questionpapers(`paper_id`,`questions_id`) values ('".$paper_id."','".$row[0]."')";
																$q3=mysql_query($q2);
																if($q3)
																{
							$q_sel=mysql_query("select * from papers where paper_id=".$paper_id);
							$re_sel=mysql_fetch_row($q_sel);
							
							$total= $re_sel['outof'] + $Marks1;
							if(mysql_num_rows($q_sel)>0)
							{
							$q_update=mysql_query("Update papers set outof=".$total." where paper_id=".$paper_id);
							}
																	header('Location:index.php#generate');
																}
															
													}
								
									}
									else
									{ 
										
										$s="select * from questions where `marks`=$Marks1 and class_id=$class_id and category_id=$category_id ORDER BY RAND() limit $Question_Mark ";
									$s_re=mysql_query($s);
				
									while($row=mysql_fetch_array($s_re))
													{

	 $q2="insert into questionpapers(`paper_id`,`questions_id`) values ('".$paper_id."','".$row[0]."')";
																$q3=mysql_query($q2);
																if($q3)
																{	
							$q_sel=mysql_query("select * from papers where paper_id=".$paper_id);							
							$re_sel=mysql_fetch_array($q_sel);
							//echo 'outof'.$Marks1;
							$total= $re_sel['outof'] + $Marks1;
							if(mysql_num_rows($q_sel)>0)
							{
								//echo $total;
							$q_update=mysql_query("Update papers set outof=".$total." where paper_id=".$paper_id);
							}
																	header('Location:index.php#generate');
																}
																
															
													}
									}

																		
							 }										
						  
			}
				
													
		  }
}
else
{
	header('Location:index.php#generate');
}


?>
<!--</table>-->
</div>
</body>
</html>
<? ob_flush(); ?>