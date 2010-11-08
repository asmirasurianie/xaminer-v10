<?php
session_start();
include('includes/connect.php');
if(isset($_SESSION['username']))
{
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <title>Xaminer</title>
   
<script src="js/popup.js" type="text/javascript"></script>
        <script src="js/jquery-1.1.3.1.pack.js" type="text/javascript"></script>
        <script src="js/jquery.history_remote.pack.js" type="text/javascript"></script>
        <script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
        <script src="js/common.js" type="text/javascript"></script>
        <!--[if IE]>
		<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript" src="pickerVars.js"></script>
<script language="JavaScript" type="text/javascript" src="picker.js"></script>
<link rel="stylesheet" type="text/css" href="calendar/calendar-win2k-cold-1.css">
<![EndIf]-->
<SCRIPT TYPE="text/javascript">
<!--
function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'width=800,height=500,scrollbars=yes');
return false;
}
//-->
</SCRIPT>

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
 <!--   <script type="text/javascript">
$(document).ready(function(){
  $("#tab1").click(function(){
  //$('#profile').load('in_process.php');
  });
  
  $("#tab2").click(function(){
  //$('#examiner').load('manage_users.php');
  });
  
  $("#tab3").click(function(){
  //$('#students').load('manage_students.php');
  });
  
  $("#tab4").click(function(){
  //$('#categories').load('manage_categories.php');
  });
  
  $("#tab5").click(function(){
 // $('#classes').load('manage_classes.php');
  });
  
  $("#tab6").click(function(){
  //$('#questions').load('addquestion.php');
  });
  
  $("#tab7").click(function(){
  //$('#generate').load('generatepaper.php');
  });
  
  $("#tab8").click(function(){
  //$('#scheduler').load('in_process.php');
  });
});
</script>-->
    </head>
    <body>
    <div id="header">
			<TABLE width="100%" height="70%" border="0">				
                <TR>
                	<TD align="left" style="vertical-align:top">
                    <img src="images/xaminer_logo.png">
					</TD>
					<TD align="right" style="font-size: 11px; vertical-align:middle">
                    <a href="logoff.php">Logout</a>&nbsp; | &nbsp;<?php echo $_SESSION['user_firstname'].'&nbsp;'.$_SESSION['user_lastname']; ?>
					</TD>
				</TR>
			</TABLE>
        </div>               
        <div id="container-5">
            <ul>
                <li><a href="#profile" id="tab1"><span>My Profile</span></a></li>
                <li><a href="#classes" id="tab2"><span>Class</span></a></li>
                <li><a href="#categories" id="tab3"><span>Categories</span></a></li>
			<?php $sql1="select * from users where username='".$_SESSION['username']."'";
			$result1=mysql_query($sql1);
			$row1=mysql_fetch_array($result1);
			if($row1['users_id']=='1') { ?>
                <li><a href="#examiner" id="tab4"><span>Examiners</span></a></li>	
			<?php }	 ?>
                <li><a href="#students" id="tab5"><span>Students</span></a></li>                                
                <li><a href="#questions" id="tab6"><span>Questions</span></a></li>
                <li><a href="#generate" id="tab7"><span>Generate Paper</span></a></li>
                <li><a href="#scheduler" id="tab8"><span>Scheduler</span></a></li>
                <?php $sql1="select * from users where username='".$_SESSION['username']."'";
			$result1=mysql_query($sql1);
			$row1=mysql_fetch_array($result1);
			if($row1['users_id']=='1') { ?>
                <li><a href="#verification" id="tab4"><span>Students Non Verified</span></a></li>	
			<?php }	 ?>
            <li><a href="#reports" id="tab9"><span>Reports</span></a></li>
            </ul>
            <div id="profile">
             <script type="text/javascript">
				$(document).ready(function(){
					$("a.editprofile").click(function() {
						$("#editprofileform").empty().load($(this).attr('href'));
						return false;
					});
				});
				</script>
                <div id="prof">
                    <div id="heading">My Profile</div>
                    <ul>
                      <li><b>First Name :</b> <?php echo $row1['user_firstname'];?> </li>
                      <li><b>Last Name :</b> <?php echo $row1['user_lastname'];?> </li>                      
                      <li><b>User Name :</b> <?php echo $row1['username'];?> </li>                      
                      <li><b>Password :</b> <?php echo $row1['password'];?> </li>
                     </ul>
                      <a href="editadmin.php?uid=<?php echo $_SESSION['users_id'];?>" class="editprofile"><input type="button" value="EDIT" name="Edit" class="edit-butt" /></a>
                    
                </div>
                <div id="editprofileform"></div>
            </div>
			
            <div id="classes">
             <!--manage Classes--> 
				<script type="text/javascript">
                 $(document).ready(function(){
                  $("#addclasses").click(function(){
                  $('#addclassesform').load(' addclasses.php');
                  });
				  
                }); 
                </script>
                <script type="text/javascript">
				$(document).ready(function(){
					$("a.editclasses").click(function() {
						$("#editclasssesform").empty().load($(this).attr('href'));
						return false;

					});
				});
				</script>
                <div>
                <b style="font-size:15px; color:#900">Manage Classes</b><br /><br />
                <?php $sql = mysql_query("select * from class ORDER BY class ASC ");
                
                if(mysql_num_rows($sql) >0){
                echo '<div style="height:220px; overflow:scroll; width:950px;"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
                echo '<tr><th><b>Class</th><th><b>Batch</th><th><b>Edit</b></th><th><b>Delete</b></th></b></th></tr>';
                while($row= mysql_fetch_array($sql))
                {
                
                echo '<tr><td>'.$row['class'].'</td><td>'.$row['batch'].'</td><td width="80"><a href="editstandard.php?stid='.$row['class_id'].'" class="editclasses"><input type="button" value="EDIT" name="Edit" class="edit-butt" /></a></td><td width="80"><a href="deletestandard.php?class_id='.$row['class_id'].'">';?>
                <input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this class?')) return true; else return false;" class="edit-butt" /></a>
                <?php
                echo '</td></tr>';
                }
                echo '</table></div>';
                }
                else
                {
                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                echo '<tr><td>No Class Found</td></tr>';
                echo '</table>';
                }
                
                ?>
                <br>
                <input type="button" id="addclasses" name="addclasses" value="Add Class" class="submit-butt">               
                </div>
                
                <div id="addclassesform"></div>
				<div id="editclasssesform"></div>
			  <!--end manage classes-->
            </div>
            
            
			<div id="categories">
              <!--manage CATEGORIES-->
				<script type="text/javascript">
                 $(document).ready(function(){
                  $("#addcategory").click(function(){
                  $('#addcategoryform').load('addcategories.php');
                  });
                }); 
                </script><script type="text/javascript">
				$(document).ready(function(){
					$("a.editcategories").click(function() {
						$("#editcategoriesform").empty().load($(this).attr('href'));
						return false;
					});
				});
				</script>
                
                <div>
                <b style="font-size:15px; color:#900">Manage Categories</b><br /><br />
                            <?php $sql = mysql_query("select * from categories ORDER BY category ASC ");
                
                if(mysql_num_rows($sql) >0){
                echo '<div style="height:220px; overflow:scroll; width:950px;"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
                echo '<tr><th><b>Category</b></th><th><b>Edit</b></th><th><b>Delete</b></th></tr>';
                while($row= mysql_fetch_array($sql))
                {
                
                echo '<tr><td width="100">'.$row['category'].'</td><td width="80"><a href="editcategories.php?editcatid='.$row['category_id'].'" class="editcategories"><input type="button" value="EDIT" name="Edit" class="edit-butt" /></a></td><td width="80"><a href="deletecategory.php?catid='.$row['category_id'].'">';?>
                <input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this category?')) return true; else return false;" class="edit-butt"/></a>
                <?php
                echo '</td></tr>';
                }
                echo '</table></div>';
                }
                else
                {
                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                echo '<tr><td>No Categories Found</td></tr>';
                echo '</table>';
                }
                
                ?>
                <br>
                <input type="button"  id="addcategory" name="addcategory" value="Add Category" class="submit-butt">
                </div>
                
                <div id="addcategoryform"></div>
                <div id="editcategoriesform"></div>
                <!--end manage CATEGORIES-->
         </div>
            <?php $sql1="select * from users where username='".$_SESSION['username']."'";
			$result1=mysql_query($sql1);
			$row1=mysql_fetch_array($result1);
			if($row1['users_id']=='1') { ?>
            <div id="examiner">
                <!--manage CATEGORIES-->
				<script type="text/javascript">
				 $(document).ready(function(){
				  $("#adduser").click(function(){
				  $('#adduserform').load('adduser.php');
				  });
				}); 
				</script>
               <script type="text/javascript">
				$(document).ready(function(){
					$("a.edituser").click(function() {
						$("#edituserform").empty().load($(this).attr('href'));
						return false;
					});
				});
				</script>
                <div>
                 <b style="font-size:15px; color:#900">Manage Users</b><br /><br />
                 
				<?php $sql = mysql_query("select * from users where users_id!='1'");
                if(mysql_num_rows($sql) >0){
                echo '<div style="height:220px; overflow:scroll; width:950px;"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
                echo '<tr><th><b>First Name</b></th><th><b>Last Name</b></th><th><b>Email Id</b></th><th><b>Branch</b></th><th><b>User Name</b></th><th><b>Password</b></th><th><b>Date Created</b></th><th><b>Edit</b></th><th><b>Delete</b></th></tr>';
                while($row= mysql_fetch_array($sql))
                {
                
                echo '<tr><td>'.$row['user_firstname'].'</td><td>'.$row['user_lastname'].'</td><td>'.$row['email_id'].'</td><td>'.$row['branch'].'</td><td>'.$row['username'].'</td><td>'.$row['password'].'</td><td>'.$row['user_created'].'</td><td><a href="edit.php?uid='.$row['users_id'].'" class="edituser"><input type="button" value="EDIT" name="Edit" class="edit-butt"/></a></td><td><a href="delete.php?uid='.$row['users_id'].'">';?>
                <input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this user?')) return true; else return false;" class="edit-butt" /></a>
                <?php
                echo '</td></tr>';
                }
                echo '</table></div>';
                }
                else
                {
                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                echo '<tr><td>No User Found</td></tr>';
                echo '</table>';
                }
                ?>
                <br>
                <input type="button" id="adduser" name="adduser" value="ADD USER" class="submit-butt">
                </div>
                
                <div id="adduserform"></div>
                 <div id="edituserform"></div>
                <!--end manages examiner-->
            </div>
            <?php } ?>
            <div id="students">
            
			<!--manage students-->
                <script type="text/javascript">
                 $(document).ready(function(){
                  $("#addstudents").click(function(){
                  $('#addstudentsform').load('addstudents.php');
                  });
				  	
                }); 
                </script>
                <script type="text/javascript">
				$(document).ready(function(){
					$("a.editstudents").click(function() {
						$("#editstudentsform").empty().load($(this).attr('href'));
						return false;
					});
				});
				</script>
                <div>
                <b style="font-size:14px; color:#900">Manage Students</b><br /><br />
                            <?php $sql = mysql_query("select * from students");
                
                if(mysql_num_rows($sql) >0){
                    
                echo '<div style="height:220px; overflow:scroll; width:1300px;"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
                echo '<tr><th><b>First Name</b></th><th><b>Last Name</b></th><th><b>Email Id</b></th><th><b>Phone</b></th><th><b>Class</b></th><th><b>Roll No</b></th><th><b>Branch</b></th><th><b>Parents/Gaurdians No.</b></th><th><b>UserName</b></th><th><b>Password</b></th><th><b>Edit</b></th><th><b>Delete</b></th></tr>';
                while($row= mysql_fetch_array($sql))
                {
                    $sql1 = mysql_query("select * from class where class_id=".$row['class_id']);
                    $row1= mysql_fetch_array($sql1);
                echo '<tr><td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td><td>'.$row['email'].'</td><td>'.$row['phone_no'].'</td><td>'.$row1['class'].'</td><td>'.$row['rollno'].'</td><td>'.$row['branch'].'</td><td>'.$row['parentsno'].'</td><td>'.$row['username'].'</td><td>'.$row['password'].'</td><td><a href="editstudents.php?uid='.$row['std_id'].'" class="editstudents"><input type="button" value="EDIT" name="Edit" class="edit-butt"/></a></td><td><a href="deletestudents.php?uid='.$row['std_id'].'">';?>
                <input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this student?')) return true; else return false;" class="edit-butt" /></a>
                <?php
                echo '</td></tr>';
                }
                echo '</table></div>';
                }
                else
                {
                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                echo '<tr><td>No User Found</td></tr>';
                echo '</table>';
                }
                            ?>
                            <br>
                            <input type="button" id="addstudents" name="addstudents" value="ADD Students" class="submit-butt">
                </div>

                
                <div id="addstudentsform"></div>
                <div id="editstudentsform"></div>
				<!--end manage students-->
            </div>
            
						
            <div id="questions">
               <!--start manage questions-->			   
				<!--<script type="text/javascript">
                 $(document).ready(function(){
                  $('#addquestion1').click(function(){
                  $('#addquestionform').load('addquestion.php');
                  });
                }); 
                </script>-->
                <script type="text/javascript">
				$(document).ready(function(){
					$("a.editquestions").click(function() {
						$("#editquestionsform").empty().load($(this).attr('href'));
						return false;
					});
				});
				</script>
                <div>
				<div id="result"></div>
                <b style="font-size:15px; color:#900">Manage Questions</b><br /><br />
                <?php $sql = mysql_query("select * from questions,class where questions.class_id=class.class_id ORDER BY questions ASC ");
                            
                            if(mysql_num_rows($sql) >0)
                            {
                                  echo '<div style="height:220px; overflow:scroll; width:900px;"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
                                  echo '<tr><th><b>Questions</b></th><th><b>Options</b></th><th><b>Class</b></th><th><b>Marks</b></th><th><b>Edit</b></th><th><b>Delete</b></th></tr>';
                                    while($row= mysql_fetch_array($sql))
                                     {
										 $sql1 = mysql_query("select * from options where options.questions_id=".$row['questions_id']);
										 $dig=explode('/',$row['ques_path']);
                					
										if($row['ques_path']=="") 
										{
										//echo "Yes";
										echo '<tr><td><pre><table border="0"><tr><td valign="top">'.$row['questions'].'</td><td><img src="'.$row['ques_path'].'"></td></tr></table></pre></td><td><table border="0"><tr>';
										}
										else {		
										//echo "No";								
                                        echo '<tr><td>'.$row['questions'].'</td><td><table border="0"><tr>';
										}
										while($row1= mysql_fetch_array($sql1))
                                     {
									 	if($row1['options']=="") 
										{
										//echo "Yes";
										echo '<td><input type="checkbox"></td><td><pre><img src="'.$row1['opt_path'].'"></pre></td>';
										}
										else {		
										echo '<td><input type="checkbox"></td><td><pre>'.$row1['options'].'</pre></td>';
										}
									 }
										echo'</tr></table></td><td>'.$row['class'].'</td><td>'.$row['marks'].'</td><td width="80"><a href="editquestions.php?qid='.$row['questions_id'].'" class="editquestions"><input type="button" value="EDIT" name="Edit" class="edit-butt"/></a></td><td width="80"><a href="deletequestions.php?qid='.$row['questions_id'].'">';?>
                                        <input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this questions?')) return true; else return false;" class="edit-butt" /></a>
                                    <?php
                                        echo '</td></tr>';
                                     }
                                 echo '</table></div>';
                            }
                         else
                          {
                                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                                echo '<tr><td>No Questions Found</td></tr>';
                                echo '</table>';
                          }
                
                ?>
                            <br>
              <a href="index.php#questions" onClick="openPopup(['addquestion.php'])"><input type="button" id="addquestion1" name="addquestion1" value="Add Question" class="submit-butt"></a>
				
                <!--<div id="addquestionform"></div>-->
                <div id="editquestionsform"></div>
                <div id="loading"></div>
                </div>
               <!--end manage questions-->
            </div>
            <div id="generate">

                <!--start manage generate-->			   
				<script type="text/javascript">
                 $(document).ready(function(){
                  $('#addquestion3').click(function(){
                  $('#addgenerate').load('generatepaper.php');
                  });
                }); 
                </script>
                
                <b style="font-size:15px; color:#900">Paper Generate</b><br /><br />
                        <?php $sql = mysql_query("select * from papers");
                            
                            if(mysql_num_rows($sql) >0)
                            {
                                  echo '<div style="height:200px; overflow:scroll; width:250px;"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
                                  echo '<tr><th><b>Paper Name</b></th><th><b>Delete</b></th></tr>';
                                    while($row= mysql_fetch_array($sql))
                                     {
                
    echo '<tr><td><a href="display.php?paper_id='.$row['paper_id'].'" target="_blank">'.$row['paper_name'].'</a></td><td><a href="deletepaper.php?paper_id='.$row['paper_id'].'">'; ?>
     
	<input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this paper?')) return true; else return false;" class="edit-butt" /></a></td>
    <?php                                
                                        echo '</td></tr>';
                                     }
                                 echo '</table></div>';
                            }
                         else
                          {
                                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                                echo '<tr><td>No Questions Found</td></tr>';
                                echo '</table>';
                          }
                
                ?>
                            <br>
                            <input type="button" id="addquestion3" name="addquestion3" value="Generate Paper" class="submit-butt">
                <div id="addgenerate"></div>
                
				 <div id="loding1"></div>
                
               <!--end manage generate-->
			   </div>
          
            
        

            <div id="scheduler">
            <!--start scheduler-->
            <!--[if ie 8]>	
            <script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" href="calendar/calendar-win2k-cold-1.css">
<![endif]-->
            <script type="text/javascript">
                 $(document).ready(function(){
                  $('#paper_name').click(function(){
                  $('#paper').load('addexamscheduler.php');
                  });
                }); 
                </script>
                <script type="text/javascript">
				$(document).ready(function(){
					$("a.editscheduler").click(function() {
						$("#editschedulerform").empty().load($(this).attr('href'));
						return false;
					});
				});
				</script>
            <b style="font-size:15px; color:#900">Manage Scheduler</b><br /><br />		
			<?php $sql = mysql_query("select * from paper_time as pt,temp_std as ts,class as cl,papers as pa where pt.paper_id=ts.paper_id and cl.class_id=ts.class_id and pt.paper_id=pa.paper_id");

				if(mysql_num_rows($sql) >0){
				echo '<div style="height:220px; overflow:scroll; width:1050px;"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
				echo '<tr><th><b>Paper Name</b></th><th><b>Start Time</b></th><th><b>End Time</b></th><th><b>Date</b></th><th><b>Class</b></th><th><b>Edit</b></th><th><b>Delete</b></th></tr>';
				while($row= mysql_fetch_array($sql))
				{
				
				echo '<tr><td>'.$row['paper_name'].'</td><td>'.$row['start_time'].'</td><td>'.$row['end_time'].'</td><td>'.$row['date'].'</td><td>'.$row['class'].'</td><td><a href="editscheduler.php?paper_id='.$row['paper_id'].'" class="editscheduler"><input type="button" value="EDIT" name="Edit" class="edit-butt" /></a></td><td><a href="deletescheduler.php?paper_id='.$row['paper_id'].'">';?>
				<input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this user?')) return true; else return false;" class="edit-butt"/></a>
				<?php
				echo '</td></tr>';
				}
				echo '</table></div>';
				}
				else
				{
				echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
				echo '<tr><td>No User Found</td></tr>';
				echo '</table>';
				}
			?>			
			<input type="button" name="paper_name" id="paper_name" value="Add Scheduler" class="submit-butt">
        	<div id="paper"></div>
            <div id="editschedulerform"></div>
			<!--end scheduler-->
            </div>
			
            <div id="verification">
            
			<!--manage verification-->
               
                <div>
                <b style="font-size:14px; color:#900">Students Non Verified</b><br /><br />
                            <?php $sql = mysql_query("select * from students where confirm='0'");
                
                if(mysql_num_rows($sql) >0){
                    
                echo '<div style="height:220px; overflow:scroll; width:1100px;"><form method="post" action="verfication_process.php"><table border=0 cellspacing="0px" cellpadding="0px"  width="100%" class="tablestyle">';
                echo '<tr><th><b>First Name</b></th><th><b>Last Name</b></th><th><b>Email Id</b></th><th><b>Phone</b></th><th><b>Class</b></th><th><b>Roll No</b></th><th><b>Branch</b></th><th><b>Parents/Gaurdians No.</b></th><th><b>UserName</b></th><th><b>Password</b></th><th><b>Edit</b></th><th><b>Delete</b></th></tr>';
                while($row= mysql_fetch_array($sql))
                {
                    $sql1 = mysql_query("select * from class where class_id=".$row['class_id']);
                    $row1= mysql_fetch_array($sql1);
                echo '<tr><td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td><td>'.$row['email'].'</td><td>'.$row['phone_no'].'</td><td>'.$row1['class'].'</td><td>'.$row['rollno'].'</td><td>'.$row['branch'].'</td><td>'.$row['parentsno'].'</td><td>'.$row['username'].'</td><td>'.$row['password'].'</td><td><input type="checkbox" name="std[]" id="std[] value="'.$row['std_id'].'"></td><td><a href="deletestudents.php?uid='.$row['std_id'].'">';?>
                <input type="button" value="DELETE" name="delete" onClick="javascript:if(confirm('Are you sure you want to delete this student?')) return true; else return false;" class="edit-butt" /></a>
                <?php
                echo '</td></tr>';
                }
                echo '<tr><td colspan="11"><input type="submit" value="submit"></td></tr></table></form></div>';
                }
                else
                {
                echo '<table border=0 width="100%" style="border:#CCCCCC 3px solid; padding-left:20px;">';
                echo '<tr><td>No New students added</td></tr>';
                echo '</table>';
                }
                            ?>
                            <br>
                            <input type="button" id="addstudents" name="addstudents" value="ADD Students" class="submit-butt">
                </div>

                
				<!--end manage verification-->
            </div>
            
             <div id="reports">
            
			<!--start reports-->
               
                <div>
                <b style="font-size:14px; color:#900">Reports</b><br /><br />
                <ul>
                	<li><a href="reports/Report1smry.php" onClick="return popup(this, 'No of ppl taking a particular test Test wise')">Students </a></li>
                    <li><a href="reports/Report7smry.php" onClick="return popup(this, 'No of ppl taking a particular test Test wise')">Yearly Exams Scheduled</a></li>
                    <li><a href="reports/Report10smry.php" onClick="return popup(this, 'No of ppl taking a particular test Test wise')">Time Taken</a></li>
                    <li><a href="reports/Report17smry.php" onClick="return popup(this, 'No of ppl taking a particular test Test wise')">No of students passed / failed</a></li>
                    <li><a href="reports/Report18smry.php" onClick="return popup(this, 'No of ppl taking a particular test Test wise')">No of students attended exam</a></li>
                    <!--<li><a href="reports/Report1smry.php" onClick="return popup(this, 'No of ppl taking a particular test Test wise')">No of ppl taking a particular test Test wise</a></li>
                    <li><a href="reports/Report2smry.php" onClick="return popup(this, 'Studentwise Tests taken')">Studentwise Tests taken</a></li>
                    <li><a href="reports/Report3smry.php" onClick="return popup(this, 'Score by test')">Score by test</a></li>
                    <li><a href="reports/Report4smry.php" onClick="return popup(this, 'No of attempts per test')">No of attempts per test</a></li>-->
                    <!--<li><a href="">Avg score</a></li>-->
                </ul>               
                </div>

                
				<!--end reports-->
            </div>
            
        </div>
        
    </body>
</html>
<?php } else {
header('Location:login.php');
}
?>
<!--[if IE]>
<script type="text/javascript">
    function CalCalender(val,but){

		Calendar.setup({
			inputField     :    val,   // id of the input field
			ifFormat       :    "%d-%m-%Y",       // format of the input field
			daFormat       :    "%d-%m-%Y",       // format of the Display field
			showsTime      :    false,
			button         :    but,
			timeFormat     :    "24",
			step           :    1
		});
		
	}
	   
	   
</script>
<![EndIf]-->