<? ob_start(); ?>
<?php
   include('includes/connect.php');
   session_start();
   $question_id=$_SESSION['question_id'];
   $id=$_POST['answerid'];
    if(!isset($_POST['addoption']))
      {
         $sizeof = 0;
      }
      else
      {
         $sizeof = $_POST['addoption123'];
      }
	

         for($i=1;$i<=$sizeof;$i++)
		     {
				 $opt=$_POST["option".$i.""];
				 $query="insert into options(options,questions_id)values('$opt','$question_id')";
			     $result=mysql_query($query);

			     if($i==$id)
					{
						$ans=$_POST["option".$i.""];
						$r1="select * from options where options='".$ans."'";
						$r2=mysql_query($r1);
						$row=mysql_fetch_row($r2);
                           $q1=mysql_query("insert into answers(questions_id,options_id)values('$question_id','".$row[0]."')");
						   header('Location:index.php#questions');
					} 
			 }
     
   /*if(isset($_POST["option"]) && !empty($_POST["option"]))
            {	
					  $Option=array_values($_POST["option"]);
					  $Optionr=array_values($_POST["optionr"]);
					 			   
					  //$User_id=array_values($_POST["user_id"]);										
	 				  $count=sizeof($Option);
					  				   				  
					  for($i=0;$i<=$count;$i++)
					    {
					   			  						  					  
					     if(trim($Option[$i])!='')
						   {
						     //echo $Option[$i];
								$option1=addslashes(trim($Option[$i]));
								$Optionr1=addslashes(trim($Optionr[$i]));
											
									if($Optionr1!="on")
									{							
										$query="insert into options(options,questions_id)values('$option1','$question_id')";
										$result=mysql_query($query);	
										//header('Location:index.php#questions');
										
									}
									else 
									 {
										$query="insert into options(options,questions_id)values('$option1','$question_id')";
										$result=mysql_query($query);
								           if($result)
								            {
									             if($i==$id)
										          {
										              echo $_POST["option".$i.""];
										          } 
								   //$sql1="select options_id from options where options='".$option1."'";
								   //echo $sql1;
									//$sql=mysql_query($sql1);
									
									
										/*while($row=mysql_fetch_array($sql))
										{

											$query1=mysql_query("insert into answers(questions_id,options_id)values('$question_id','".$row[0]."')");
											header('Location:index.php#questions');
										}*/
								//}
								/*else
								{
									//header('Location:index.php');
								}*/
							 /*        }
											
																																						
																				
						  }										
					  
		  }
					
    }	 
 }
	  
	  
	  
	  
	  
	  
	  
   //$ci=0;
     /*if(!isset($_REQUEST['addoption']))
      {
         $sizeof = 0;
      }
      else
      {
         $sizeof = $_REQUEST['addoption'];
      }*/
	  
	  /*
	    $d=$_REQUEST['count'];
		$change=$_REQUEST['size'];
		$opt=explode('@',$d);
		$answer=$_REQUEST['answer'];
	     for($i=0;$i<$change;$i++)
		   {
			  $option=$opt[$i];
			  $query="insert into options(options,questions_id)values('$option','$question_id')";
			  $result=mysql_query($query);
			  
		   }
		$find="select options_id from options where options='".$answer."' and questions_id='".$question_id."'";
		$find1=mysql_query($find);
		$resultans=mysql_fetch_row($find1);  
		$query1="insert into answers(questions_id,options_id)values('$question_id','$resultans[0]')";
        $result1=mysql_query($query1);	
		  
		  if($result1)
		    {
			   header('Location:manage_questions.php');
			}
			else
			{
			  header('Location:index.php');
			}
		*/  
		            
	   
?>
<? ob_flush(); ?>