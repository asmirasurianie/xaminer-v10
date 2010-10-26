<?php 
include('includes/connect.php');
?>
<script type="text/javascript">
				$(document).ready(function(){
					$("#cancel").click(function() {
						$("#que").hide();
						return false;
					});
				});
				</script>
<div id="que" class="editprocess">
<div id="title">Edit Questions<div>



	  <?php 
			$sql = mysql_query("select * from questions as qu,class as cl,categories as cat where qu.class_id=cl.class_id and cat.category_id=qu.category_id and qu.questions_id='".$_REQUEST['qid']."'");

if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);

			?>

			
			  <form name="frmAddStandard" id="frmAdduser" method="post" action="editquestions_process.php" enctype="multipart/form-data">
			  <input type="hidden" name="questions_id" value="<?php echo $_REQUEST['qid'];?>">
               <table  border="0" width="40%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
			
                <tr>
                  <td class="login">Question:</td>
                  <td class="ip"><textarea rows="5" cols="20" id="question" name="question"><?php echo $row['questions'];?></textarea></td>
                </tr>
                <tr>
                  <td class="login">Class: :</td>
                  <td class="ip"><select name="sclass" id="sclass">
	 <?php
	    $query1="select * from class";
		$result1=mysql_query($query1);
		while($row1=mysql_fetch_row($result1))
		  {
		     if($row1[0]==$row['class_id'])
			  {
				echo "<option value='".$row1[0]."' selected='selected'>".$row1[1]."</option>";
			  }
			  else
			  {
				  echo "<option value='".$row1[0]."'>".$row1[1]."</option>";
			  }
		  }
	 ?>
	 </select></td>
                </tr>
				 <tr>
                  <td class="login">Category:</td>
                  <td class="ip"><select name="scategory" id="scategory"><option value="0">Select Category</option>
	 <?php
	    $query2="select * from categories";
		$result2=mysql_query($query2);
		while($row2=mysql_fetch_row($result2))
		  {	
			if($row2[0]==$row['category_id'])
			  {
				echo "<option value='".$row2[0]."' selected='selected'>".$row2[1]."</option>";
			  }
			  else
			  {
				  echo "<option value='".$row2[0]."'>".$row2[1]."</option>";
			  }
		  }
	 ?>
	 </select></td>
                </tr>
				 <tr>
                  <td class="login">Marks:</td>
                  <td class="ip"><input type="text" id="marks" name="marks" value="<?php echo $row['marks'];?>"></td>
                </tr>
				 
                <tr>
                  <td valign="top" colspan="2" align="center">
				   <input type="submit" value="UPDATE" name="update" id="update"/></td>
					<td><input type="button" name="cancel" value='CANCEL' id="cancel"></td>
                </tr>
              </table>
            </form>
				<?php } ;?>
            
   </div>  