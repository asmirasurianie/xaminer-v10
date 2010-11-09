<?php
 include('includes/connect.php');
?>
<script src="js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="js/common.js"></script>
<form name="createpaper" method="POST" action="generatepaper_process.php"> 
  <table>
     <tr>
       <td>Enter Papername</td>
	   <td><input type="text" name="papername" id="papername"></td>
	   <td><div id="r1"></div></td>
	    </tr>
        <tr>
      <td>Select Category</td><td><select name="categoryname" id="categoryname"><option value="0" selected>Select</option>
         <?php $query1=mysql_query("select * from categories");  
          while( $row1=mysql_fetch_array($query1))
           { 
	           extract($row1);
	           echo "<option value='".$category_id."'>".$category."</option>"; 
           }?>
		 </select>
		</td>
		<td><div id="r3"></div></td>
		
      </tr> 
    <tr>
      <td>Select Class</td>
	  <td><select name="classname" id="classname" onchange="return recordClass(this.form)"><option value="0" selected>Select</option>
       <?php $query=mysql_query("select * from class");  
         while( $row=mysql_fetch_array($query))
          { 
	          extract($row);
	          echo "<option value='".$class_id."'>".$class."</option>"; 
          }
	   ?>
     </select>
	 </td>
	 <td><div id="r2"></div></td>
	
    </tr>
          
      <tr>
      <div id="marks"></div>
      
      </tr>
      <tr>
          <td colspan="3"><div id="r4"></div></td>		  
      </tr>
	  <tr>
          <td><input type="submit" value="Print Paper" id="generatpaper123" name="generatpaper123" onClick="return checkpaper();" class="sub-butt"/></td><td><input type="button" value="cancel" class="sub-butt" onClick="cancelpaper();return false;"/></td>
	  </tr>
</table>
</form>
<div id="loding1"></div>



