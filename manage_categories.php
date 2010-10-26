<?php
@session_start();
include('includes/connect.php');
?>

<script type="text/javascript">
 $(document).ready(function(){
  $("#addcategory").click(function(){
  $('#addcategoryform').load('addcategories.php');
  });
}); 
</script>



<script type="text/javascript">
$(function() {
	$("a.deletecategory").click(function() {
		$("div#deletecategoryform").empty().load($(this).attr('href'));
		return false;
	});
});
</script>
<div>
<b style="font-size:15px; color:#900">Manage Categories</b><br /><br />
			<?php $sql = mysql_query("select * from categories ORDER BY category ASC ");

if(mysql_num_rows($sql) >0){
echo '<table border=0 cellspacing="2px" cellpadding="0px"  width="70%">';
echo '<tr class="tableheader"><td><b>'.'Category'.'</b></td><td><b>'.'Edit'.'</b></td><td><b>'.'Delete'.'</b></td></tr>';
while($row= mysql_fetch_array($sql))
{

echo '<tr><td width="100">'.$row['category'].'</td><td width="80"><a href="editcategories.php?editcatid='.$row['category_id'].'"><input type="button" value="EDIT" name="Edit" class="submit-butt" /></a></td>'.'<td width="80"><a class="deletecategory" name="deletecategory" href="deletecategory.php?catid='.$row['category_id'].'">';?>
<input type="button" value="DELETE" name="delete" onclick="javascript:if(confirm('Are you sure you want to delete this standard?')) return true; else return false;" class="submit-butt"/></a>
<?php
echo '</td></tr>';
}
echo '</table>';
}
else
{
echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
echo '<tr><td>No Categories Found</td></tr>';
echo '</table>';
}

?>
<br>
<input type="button" style="width:130px; height:35px;font-weight:bold;" id="addcategory" name="addcategory" value="Add Category" class="submit-butt">
</div>

<div id="addcategoryform"></div>
<div id="deletecategoryform"></div>
