
<?php
 include('includes/connect.php');
 $class=$_POST['sclass'];
 $category=$_POST['scategory'];
 //adding question here 
  if(!isset($_POST['questionid']))
    {		
	  $count=0;
	}
  else
   {
     $count=$_POST['questionid'];	  
   }
 
   	//echo $count;
    //this loop for adding the questions here
	  for($i=0;$i<=$count;$i++)
	    {
			
			//$try=tinyMCE.get('question0').getContent();
			//echo "question".$i;
		  $ques=$_POST["question".$i.""];
		  $mark=$_POST["marks".$i.""];
		  $toption=$_POST["addoptionq".$i.""];
		  $id=$_POST["answerid".$i.""];
		  $file=$_FILES["file".$i.""]["name"];
		  //echo 'go 1';
		  //echo $ques;			 
		        if(!$file)
		         {
			      $que_path=" ";
			     }
				 else
				 {
				    move_uploaded_file($_FILES["file".$i.""]["tmp_name"],"upload/" . $_FILES["file".$i.""]["name"]);
				   $que_path="upload/".$file;
				   
				 }
			
			$ques = str_replace("\\", "\\\\", $ques);
		   
		  $query="Insert into questions (questions,ques_path,category_id,class_id,marks) values('$ques','$que_path','$category','$class','$mark')";	
		
					   mysql_query($query);
		  
		
		    //add more options here
		     $query2="select questions_id from questions where questions='".$ques."'";
			 $result2=mysql_query($query2);
			 $question_id=mysql_fetch_row($result2);
			      for($j=1;$j<=$toption;$j++)
				   {
				       $opt=$_POST["optionq".$i."".$j];
					   $ofile=$_FILES["ofile".$i."".$j]["name"];
							if(!$ofile)
							   {
								  $opt_path=" ";
							   }
							 else
							 {
								move_uploaded_file($_FILES["ofile".$i."".$j]["tmp_name"],"upload/" . $_FILES["ofile".$i."".$j]["name"]);
								$opt_path="upload/".$ofile;
							 }
							 
							 $opt = str_replace("\\", "\\\\", $opt);
					   $query1="insert into options(options,opt_path,questions_id)values('$opt','$opt_path','$question_id[0]')";
					   mysql_query($query1);
					      if($j==$id)
						    {
								  
								   $ans=$_POST["optionq".$i."".$j];
								   if($ans=="")
									 {
										$opt1="upload/".$_FILES["ofile".$i."".$j]["name"];
										echo $opt1;
										$r3="select * from options where opt_path='".$opt1."'";
										$r4=mysql_query($r3);
										$row1=mysql_fetch_row($r4);
										$q1=mysql_query("insert into answers(questions_id,options_id)values('$question_id[0]','".$row1[0]."')");
										header('Location:index.php#question');
									 }
									else
									{
										$r1="select * from options where options='".$ans."'";
										$r2=mysql_query($r1);
										$row=mysql_fetch_row($r2);
										$q1=mysql_query("insert into answers(questions_id,options_id)values('$question_id[0]','".$row[0]."')");
										header('Location:index.php#question');
									}	
						       //header('Location:index.php#question');
							}
				   }	
		}

 ?>
