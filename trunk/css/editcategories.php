<?php 
include('includes/connect.php');
?>
</script><script type="text/javascript">
				$(document).ready(function(){
					$("#cancel").click(function() {
						$("#cat").hide();
						return false;
					});
				});
				</script>
<div id="cat">
<div id="title">Edit Category</div>

<tableborder="0" cellpadding="2" cellspacing="2">
  <tr class="main">
    <td colspan="2" align="center" class="errorText">&nbsp;</td>
  </tr>
  </table>


   
   
  
		 

		  <?php 
			$sql = mysql_query("select * from categories where category_id='".$_REQUEST['editcatid']."'");

if(mysql_num_rows($sql) >0){
$row= mysql_fetch_array($sql);

			?>

			
				 <form name="frmAddStandard" id="frmAdduser" method="post" action="editcategory_process.php" enctype="multipart/form-data">
				 	 <input type="hidden" name="category_id" value="<?php echo $_REQUEST['editcatid'];?>">
               <table  border="0"  width="40%" cellspacing="15" cellpadding="2"  align="left" summary="Password Forgoten Table">
			   
                <tr>
                  <td class="login" width="10%">Category :</td>
                  <td class="ip"><input type="text" id="category" name="category" value="<?php echo $row['category'];?>"></td>
                </tr>
               <tr><td></td></tr>
                <tr>
                  <td valign="top" colspan="2" align="center">
				   <input type="submit" value="UPDATE" name="update" id="update"/>
                   <input type="button" name="cancel" value='CANCEL'  id="cancel"></td>
                </tr>
				<tr><td></td></tr>
              </table>
            </form>
           
				<?php } ;?>
            
     


 </div>			   