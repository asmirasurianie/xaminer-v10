<? ob_start(); ?>
<?php
  session_start();
  include('includes/connect.php');
  $question=$_REQUEST['question'];
  $class=$_REQUEST['sclass'];
  $category=$_REQUEST['scategory'];
  //echo $category;
  $mark=$_REQUEST['marks'];
    $query="Insert into questions (questions,category_id,class_id,marks) values('$question','$category','$class','$mark')";
	$result=mysql_query($query);
	  if($result)
	   {
	     $query1="select * from questions where questions='".$question."'";
		 $result1=mysql_query($query1);
		 $result2=mysql_fetch_row($result1);
		 $_SESSION['question_id']=$result2['0'];
		 //echo $_SESSION['question_id'];
	     //header('Location:addquestions.php');
		 
	   }
    else
	   {
	    // header('Location:addquestions.php');
	   } 
?>
<? ob_flush(); ?> 