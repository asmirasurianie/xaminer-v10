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
$paper_name= $_POST['paper'];

if(isset($_POST["questions"]) && !empty($_POST["questions"])){	
					  $Questions=array_values($_POST["questions"]);
					  $Options=array_values($_POST["options"]);
					  
	 				  $count=sizeof($Questions);										  
					  for($i=0;$i<=$count;$i++){					  						  					  
					     if(trim($Questions[$i])!=''){
						    $Questions_ID=addslashes(trim($Questions[$i]));
							$Options_ID=addslashes(trim($Options[$i]));							
							//echo $Questions_ID.'<br>';
							//echo $Options_ID.'<br>';
							

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
			}
						
		  }	
	
	$sql2="Update class_std set `attempt`='1', `totalmarks`=$totalmarks where std_id=".$_SESSION['student_id']." and paper_name='".$paper_name."'";
	$result2=mysql_query($sql2);
	echo "dd";
	if($result2) {
		header('Location:index.php#attendschedule');
	}

?>
</div>
</body>
</html>
<? ob_flush(); ?>