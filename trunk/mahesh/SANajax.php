<?php
$strPage = $_REQUEST[Page]
if($_REQUEST[mode]=="Listing"){
$query = "SELECT * FROM students";
$result = mysql_query($query) or die(mysql_error());
 
$Num_Rows = mysql_num_rows ($result);

$Per_Page = 5;   // Records Per Page
 
$Page = $strPage;
if(!$strPage)
{
	$Page=1;
}
 
$Prev_Page = $Page-1;
$Next_Page = $Page+1;
 
$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($Num_Rows&lt;=$Per_Page)
{
	$Num_Pages =1;
}
else if(($Num_Rows % $Per_Page)==0)
{
	$Num_Pages =($Num_Rows/$Per_Page) ;
}
else
{
	$Num_Pages =($Num_Rows/$Per_Page)+1;
	$Num_Pages = (int)$Num_Pages;
}
 
$query.=" order  by std_id ASC LIMIT $Page_Start , $Per_Page";
$result = mysql_query($query) or die(mysql_error());
?>
<table border="0">
<tbody>
<tr>
<td>Name</td>
<td>Email</td>
</tr>
<?php
// Insert a new row in the table for each person returned
while($data= mysql_fetch_array($result)){ ?>
<tr>
<td><?php echo $data['first_name'] ?></td>
<td><?php echo $data['email'] ?></td>
</tr>
<div class="resultbg pagination">
<!--Total <?php //echo $Num_Rows;?> Record : -->
<?php
if($Prev_Page) 
{
	echo " <li><a href=\"JavaScript:SANAjax('Listing','$Prev_Page')\"> << Back</a> </li>";
}
 
for($i=1; $i<=$Num_Pages; $i++){
	if($i != $Page)
	{
		echo " <li><a href=\"JavaScript:SANAjax('Listing','$i')\">$i</a> </li>";
	}
	else
	{
		echo "<li class='currentpage'><b> $i </b></li>";
	}
}
if($Page!=$Num_Pages)
{
	echo " <li><a href=\"JavaScript:SANAjax('Listing','$Next_Page')\">Next >></a> </li>";
}
?>
</div>
<?php
############
}else{
echo "<div class='error'>No Records Found!</div>";
}
 } 
 
 ?>
</tbody></table>
