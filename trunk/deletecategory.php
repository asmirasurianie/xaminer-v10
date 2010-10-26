<? ob_start(); ?>
<?php
include('includes/connect.php');

$ques_sel=mysql_query("select * from questions where category_id=".$_REQUEST['catid']);
while($res_que=mysql_fetch_array($ques_sel))
{ 
	
	$opt_sel=mysql_query("select * from options where questions_id=".$res_que['questions_id']);
	while($res_opt=mysql_fetch_array($opt_sel))
	{
		
	$ans_del="delete from answers where options_id=".$res_opt['options_id'];
	$res_ans=mysql_query($ans_del);	
	}
	$opt_del="delete from options where questions_id=".$res_que['questions_id'];
	$optres=mysql_query($opt_del);
	
	/*$pa_sel=mysql_query("select * from questionpapers where questions_id=".$res_que['questions_id']);
	while($res_pa=mysql_fetch_array($pa_sel))
	{
	
	$cs_del="delete from class_std where paper_id=".$res_pa['paper_id'];
	$res_cs=mysql_query($cs_del);
	
	$sql_std="delete from temp_std where paper_id=".$res_pa['paper_id'];
	$re_std=mysql_query($sql_std);

	$sql_papert="delete from paper_time where paper_id=".$res_pa['paper_id'];
	$result_papert=mysql_query($sql_papert);
	
	$sql_papers="delete from papers where paper_id=".$res_pa['paper_id'];
	$result_papers=mysql_query($sql_papers);	
	}*/
	$sql_paper="delete from questionpapers where questions_id=".$res_que['questions_id'];
	$result_paper=mysql_query($sql_paper);
}


$sql_q="delete from questions where category_id=".$_REQUEST['catid'];
$resultq=mysql_query($sql_q);

$sqlc="delete from categories where category_id=".$_REQUEST['catid'];
$resultc=mysql_query($sqlc);


header("location:index.php#categories");
?>
<? ob_flush(); ?>