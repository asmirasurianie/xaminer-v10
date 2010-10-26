<?php
include('includes/connect.php');
session_start();

if(isset($_POST["std"]) && !empty($_POST["std"])){	
						  $Std=array_values($_POST["std"]);
									
						  $count=sizeof($Std);										  
						  for($i=0;$i<=$count;$i++){					  						  					  
							 if(trim($Std[$i])!=''){
								$StdID=addslashes(trim($Std[$i]));
								
								echo $StdID.'<br>';
								
								$sql="Update students set `confirm`='1' where std_id=".$StdID;
								$result=mysql_query($sql);
								if($result)
								{
									header("location:index.php#verification");
								}
																					
							 }										
						  
			}
						
		  }
	
?>