<?php
require('includes/connect.php');



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


while($row=mysql_fetch_array($result1))
		  {
			  
			$totalmarks=$totalmarks +$row[0];
			
		  }

																																			
																				
						 }										
					  
		}
					
	  }	
echo 'The score scored by you in this exam is &nbsp;'.$totalmarks.'<br>';	  
?>