<?php
  include('includes/connect.php');
  session_start();
  $question_id=$_SESSION['question_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Answer of question</title>
<script type="text/javascript" src="js/comman.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
</head>
<body>
<div id="addoption"></div>
  <form name="answer_question" id="answer_question" method="post" action="answer_question_process.php">
      <h4>Answer:</h4><br/>
	  <select name="answer_q" id="answer_q"><option value="0">select answer</option>
	     <?php
		    $query="select * from options where questions_id='".$question_id."'";
			$result=mysql_query($query);
			  while($row=mysql_fetch_array($result))
			    {
				  echo "<option value='".$row[0]."'>".$row[1]."</option>";
				} 
		 ?>
		 </select>
		 <input type="submit" value="Submit" />
		 <input type="button" value="Cancel" onclick="getquestionOption(<?php echo $question_id;?>)"/>
  </form>
</body>
</html>
