<?php
session_start();
include('includes/connect.php');
//echo $_POST['categoryname'];

if($_POST['categoryname']=='0')
{
	//echo $_POST['classname'];

$q1="SELECT distinct(marks) from questions where class_id=".$_POST['classname'];
$r1=mysql_query($q1);
$i=0;
	if(mysql_num_rows($r1)>0)
	{
		echo '<tr><td colspan="3">Total marks Question paper</td></tr>';
	   while($row2=mysql_fetch_row($r1))
		 {
			 
			  $q2="select count(questions_id) from questions where marks='".$row2[0]."' and class_id=".$_POST['classname'];
			  $r2=mysql_query($q2);
			  $count=mysql_fetch_row($r2);			
			  echo $row2[0].'&nbsp;['.$count[0].'] &nbsp; <input type="hidden" value="'.$row2[0].'" name="marks[]" id="marks[]"><input type="text" name="question_mark[]" id="question_mark[]" size=25/><br>'  ;
			  $i++;
		 }
	}
	else {
		echo '<b style="color:red;">No questions</b>';
	}
}
else {
	
$q1="SELECT distinct(marks) from questions where `class_id`=".$_POST['classname']." and `category_id`=".$_POST['categoryname'];
$r1=mysql_query($q1);
$i=0;
if(mysql_num_rows($r1)>0)
	{
		echo '<tr><td colspan="3">Total marks Question paper</td></tr>';
   while($row2=mysql_fetch_row($r1))
     {
		 
	      $q2="select count(questions_id) from questions where marks=".$row2[0]." and `class_id`=".$_POST['classname']." and `category_id`=".$_POST['categoryname'];
		  $r2=mysql_query($q2);
		  $count=mysql_fetch_row($r2);
		  echo $row2[0].'&nbsp;['.$count[0].'] &nbsp; <input type="hidden" value="'.$row2[0].'" name="marks[]" id="marks[]"><input type="text" name="question_mark[]" id="question_mark[]" size=25/><br>'  ;
		  $i++;
	 }
}
	else {
		echo '<b style="color:red;">No questions</b>';
	}
}
	
?>
