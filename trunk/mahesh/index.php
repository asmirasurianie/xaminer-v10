<?php
session_start();
include('../includes/connect.php');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <title>Xaminer</title>
        <script src="js/jquery-1.1.3.1.pack.js" type="text/javascript"></script>
        <script src="js/jquery.history_remote.pack.js" type="text/javascript"></script>
        <script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
        <script src="js/common.js" type="text/javascript"></script>
        <link href="style/style.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript">
            $(function() {
                
                $('#container-5').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'normal' });                                

            });
        </script>
      
		<link rel="stylesheet" href="css/style.css" type="text/css">
        <link rel="stylesheet" href="css/jquery.tabs.css" type="text/css" media="print, projection, screen">
        <!-- Additional IE/Win specific style sheet (Conditional Comments) -->
        <!--[if lte IE 7]>
        <link rel="stylesheet" href="css/jquery.tabs-ie.css" type="text/css" media="projection, screen">
        <![endif]-->
        <style type="text/css" media="screen, projection">

            /* Not required for Tabs, just to make this demo look better... */

            body {
                font-size: 16px; /* @ EOMB */
            }
            * html body {
                font-size: 100%; /* @ IE */
            }
            body * {
                font-size: 87.5%;
                font-family: "Trebuchet MS", Trebuchet, Verdana, Helvetica, Arial, sans-serif;
            }
            body * * {
                font-size: 100%;
            }
            h1 {
                margin: 1em 0 1.5em;
                font-size: 18px;
            }
            h2 {
                margin: 2em 0 1.5em;
                font-size: 16px;
            }
            p {
                margin: 0;
            }
            pre, pre+p, p+p {
                margin: 1em 0 0;
            }
            code {
                font-family: "Courier New", Courier, monospace;
            }
        </style>
  <script type="text/javascript">
$(document).ready(function(){
  //$("#tab1").click(function(){
  //$('#scheduleexam').load('schedule_exam.php');
  //});
  
  //$("#tab2").click(function(){
  //$('#attendschedule').load('attend_schedule.php');
  //});
  
  $("#tab3").click(function(){
  $('#registration').load('studentregistration.php');
  });
  
  $("#tab4").click(function(){
  $('#changepassword').load('change_password.php');
  });
  

   
 
});
</script>
     </head>
    <body>
    <div id="header">
			<TABLE width="100%" height="70%" border="0">				
                <TR>
                	<TD align="left" style="vertical-align:middle">
                    <img src="images/mt_logo.gif">
					</TD>
                    <TD align="left" style="vertical-align:top">
                    <img src="images/xaminer_logo.png">
					</TD>                    
					<TD align="right" style="font-size: 11px; vertical-align:middle">
                    <?PHP
					if(isset($_SESSION['username']))
						{
					?>
                    <a href="logoff.php">Logout</a>&nbsp; | &nbsp;<?php echo $_SESSION['first_name'].'&nbsp;'.$_SESSION['last_name']; ?>
                    <?php } else { ?>
                    <a href="login.php">Login</a>
                    <?php } ?>
					</TD>
				</TR>
			</TABLE>
        </div> 
		<div id="container-5">
            <ul>
            <?PHP
			if(isset($_SESSION['username']))
				{
			?>
                <li><a href="#scheduleexam" id="tab1"><span>Scheduled Exams</span></a></li>
                <li><a href="#attendschedule" id="tab2"><span>Exams Attended</span></a></li>                
			    <li><a href="#changepassword" id="tab4"><span>Change Your Password</span></a></li>
             <?php } else {?>	
			    <li><a href="#registration" id="tab3"><span>Registration</span></a></li>           
                <?php } ?>
            </ul>
            
			  <?PHP
			if(isset($_SESSION['username']))
				{
			?>       
			
            <div id="scheduleexam">
             <!--schedule exam--> 
				
             
<table border="0">
  <tr>
</td>

    <td>	          
     <table border="0">
         <tr valign="top">
          <td>
		  <h3> Scheduled Exam</h3>
          <?php 
		  $sql_std=mysql_query("select * from students where username='".$_SESSION['username']."'");
		  $result_std=mysql_fetch_array($sql_std);
		  $std_id = $result_std['std_id'];
		  
		  $sql = mysql_query("select * from papers as pa,paper_time as pt,temp_std as ts,students as std where pa.paper_id=pt.paper_id and pt.paper_id=ts.paper_id and ts.class_id = std.class_id and std.std_id=".$std_id);
if(mysql_num_rows($sql) >0){
	
	
echo '<table border=0 cellspacing="0px" cellpadding="0px" width="500px">';
echo '<tr><td><b>Paper Name</b></td><td><b>Date</b></td><td><b>Start Time</b></td><td><b>End Time</b></td><td><b>All time</b></td></tr>';
while($row= mysql_fetch_array($sql))
{
	//$sql_att = mysql_query("select * from class_std where std_id=".$std_id." and paper_id=".$row['paper_id']);
	//if(mysql_num_rows($sql_att) >0){
//echo '<tr><td>No paper</td><td>empty</td><td>empty</td><td>empty</td></tr>';
	//}
	//else {
	
echo '<tr><td><a href="display_paper.php?paper_id='.$row['paper_id'].'">'.$row['paper_name'].'</a></td><td>'.$row['date'].'</td><td>'.$row['start_time'].'</td><td>'.$row['end_time'].'</td><td>'.$row['all_time'].'</td></tr>';
	//}
}
echo '</table>';

}
else
{
	
echo '<table border=0 width="100%" padding-left:20px;">';
echo '<tr><td style="color:#930;"><b>No exams scheduled for you</b></td></tr>';
echo '</table>';

}
		  ?>
		
			
			
            
      </td>
       </tr>
      </table>
             </td>
  </tr>
</table>
                              
			  <!--end schedule exam-->
            </div>
            
            						
	<div id="attendschedule">
              <!--attend Schedule-->
				
                <table border="0">
  <tr>
</td>

    <td>	          
     <table border="0">
         <tr valign="top">
          <td>
		  <h3> Attended Exam</h3>
          
			<?php
			$data = array();
			$tableSize = 300;
			$chartTitle1 = 'Exam Dates / Time';
			$chartTitle2 = 'Marks';
			require_once('chart.php');
			session_start();
			include('../includes/connect.php');
			$sql_std=mysql_query("select * from students where username='".$_SESSION['username']."'");
		    $result_std=mysql_fetch_array($sql_std);
		    $std_id = $result_std['std_id'];
		  
			$sql = mysql_query("select * from class_std as cs,papers as pa,students as std where cs.paper_id=pa.paper_id and cs.std_id=std.std_id and std.std_id=".$std_id);
			if(mysql_num_rows($sql) >0){
			$i='0';
			while($row= mysql_fetch_array($sql))
			{
			$data[$i]['title'] = $row['attended_date'].'&nbsp;'.$row['attended_time'];
			$data[$i]['value'] = $row['totalmarks'].'/'.$row['outof'];
			$i++;
			}
			}
			/**************** F I L L   D A T A   A R R A Y *******************************/
			/*
			$data[0]['title'] = '27 August 2010 10:30am';
			$data[0]['value'] = 254;
			$data[1]['title'] = '26 August 2010 10:30am';
			$data[1]['value'] = 489;
			$data[2]['title'] = '25 July 2010 10:30am';
			$data[2]['value'] = 975;
			$data[3]['title'] = '24 June 2010 10:30am';
			$data[3]['value'] = 563;
			$data[4]['title'] = '23 May 2010 10:30am';
			$data[4]['value'] = 195;
			*/
			/******************************************************************************/
			?>
			
				<div id="main">
				  <div class="caption"><?php echo $result_std['first_name'].'&nbsp;'.$result_std['last_name'];?> [ Performance Chart]</div>
				  <div id="icon">&nbsp;</div>
				  <div id="result">
					 <?php drawChart($data); ?>
				  </div>   
				   <div id="source">Xaminer Reports v3.2</div>
				</div>
			</body>   		
			<br>
			
            
      </td>
       </tr>
      </table>
             </td>
  </tr>
</table>
                              
		
               
                <!--end attend scheduler-->
            </div>
            
           
						            
            
			
			<div id="changepassword">
            
			<!--change password-->

 

<table width="70%"  border="0" style="border:#000 1px solid;"  align="left" cellpadding="2" cellspacing="2">
  <tr>
   

    <td valign="top">
	
      
    
     <table width="70%" align="center"  border="0" cellspacing="0" cellpadding="0" summary="Table holding Store Information">
         <tr valign="top">
          <td width="100%">
            <form name="chkpassfrm" action="change_process.php" method="post">
              <table border="0" width="100%" cellspacing="3" cellpadding="2" align="center" summary="Password Forgoten Table">
                <tr>
                  <td colspan="2" height="10">
                    </td>
                </tr>
              </table>
              <table   border="0" width="50%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
                <tr>
                  <td class="login"><b>Change Password </b></td>
                  <td class="login"></td>
				  
                </tr>
				<tr><td></td></tr>
				<tr>
                  <td class="login">Enter your current password :</td>
                  <td class="login"><input  type="password" id="currentpass" name="currentpass" value=""></td>
                </tr>
                <tr>
                  <td class="login">Enter New password :</td>
                  <td class="login"> <input  type="password" name="newpass" id="newpass" value=""></td>
                </tr>
				 <tr>
                  <td class="login">Confirm your new password :</td>
                  <td class="login"> <input  type="password" name="confirmpass" id="confirmpass" value=""></td>
                </tr>
				<tr>
				<td>&nbsp;</td>
				</tr>
                <tr>
                  <td>&nbsp;</td>
                  <td valign="top" align="left">
				   <input type="button" value="UPDATE" name="update" onClick="return checkpasswordForm('chkpassfrm')" id="update"/>
                    &nbsp;</td>
                </tr>
              </table>
            </form>
           
      </td>
       </tr>
      </table>
             </td>
  </tr>
</table>


				<!--end change password-->
            </div>
            
    
    	<?php } else { ?>	      
     <div id="registration">
                <!--registration-->
		

<form name="frmAdduser" id="frmAdduser" method="post"  enctype="multipart/form-data" action="addstudents_process.php">
    <table   border="0" width="40%" cellspacing="3" cellpadding="2"  align="left" summary="Password Forgoten Table">
        <tr>
        	<td colspan="2" align="center"><h3>Add Students</h3></td>
        </tr>
        <tr>
        <td>First Name :</td>
        	<td><input  type="text" id="fname" name="fname" value=""></td>
			<td><div id="r1"></div></td>
	    </tr>
        <tr>
            <td>Last Name:</td>
            <td><input  type="text" id="lname" name="lname" value=""></td>
			
        </tr>
        <tr>
            <td class="login">Email Address:</td>
            <td class="login" ><input  type="text" name="email" id="email" value=""></td>
			<td><div id="r2"></div></td>
			
        </tr>
        <tr>
            <td class="login">Phone:</td>
            <td class="login" ><input  type="text" name="phone" id="phone" value=""></td>
			<td><div id="r3"></div></td>
	     </tr>
        <tr>
            <td class="login">Class:</td>
            <td class="login"><select name="classname" id="classname"><option value="0">Select Class</option>
			<?php
            $query=mysql_query("select * from class");
            while($row=mysql_fetch_array($query))
            {
              echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
			?>
            </select>
            </td>
		 </tr>
        <tr><td class="login">Roll No.:</td>
		<td class="login"><input type="text" name="rollno" id="rollno" value=""></td>
		<td><div id="r4"></div></td>
		</tr>
        <tr><td class="login">Branch:</td>
		<td class="login"><input type="text" name="branch" id="branch" value=""></td>
		</tr>
        <tr><td class="login">Gaurdian/ Parents Contact No.:</td>
		<td class="login"><input type="text" name="parentsno" id="parentsno" value=""></td>
		<td><div id="r5"></div></td>
		</tr>
        <tr>
       	 <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" colspan="2" align="left">
        	<input type="submit" value="SUBMIT" name="addstudent" id="addstudent" onClick="return  checkstudents();"/>&nbsp;</td>
        </tr>
    </table>
</form>

              
                <!--end registration-->
            </div>
     
            
     <?php } ?>   
 


