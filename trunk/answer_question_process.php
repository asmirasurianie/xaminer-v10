<?php
  include('includes/connect.php');
  session_start();
  $question_id=$_SESSION['question_id'];
  $option=$_POST['answer_q'];
  
  $query="insert into answers(questions_id,options_id)values('$question_id','$option')";
  $result=mysql_query($query);
    if($result)
	  {
	      header('Location:index.php#questions');
		  
	  }
	
?>