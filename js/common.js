//var $ = jQuery.noConflict();	 
function reloadMCE(){
tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
}

 function submitusers()
 {
   
    $("#addusers").click(function()
				          { 
							  $('.error').hide();
							 var d1=$('#fname').val();
							 var d2=$('#lname').val();
							 var d3=$('#email').val();
							 var d4=$('#username').val();
							 var d5=$('#password').val();


							  if(d1=="" && d2=="" && d3=="" && d4=="" && d5=="") 
							     {
									 $("label#fname_error").show(); 
									 $("label#lname_error").show();
									 $("label#email_error").show();
									 $("label#uname_error").show(); 
									 $("label#pass_error").show();
                                    // $("#question").focus();  
                                     return false; 
								 }
								  if(d1=="" && d2=="" && d3=="" && d4=="")
								  {
									 $("label#fname_error").show();
									 $("label#lname_error").show();
									 $("label#email_error").show();
									 $("label#uname_error").show();
									 return false;
								 }
								 if(d1=="" && d3=="" && d4=="" && d5=="")
								  {
									 $("label#fname_error").show();
									 $("label#email_error").show();
									 $("label#uname_error").show();
									 $("label#pass_error").show();
									 return false;
								 }
								 
								 if(d2=="" && d3=="" && d4=="" && d5=="")
								  {
									 $("label#lname_error").show();
									 $("label#email_error").show();
									 $("label#uname_error").show(); 
									 $("label#pass_error").show(); 
									 return false;
								  }
								  if(d1=="" && d2=="" && d4=="")
								  {
									 $("label#fname_error").show(); 
									 $("label#lname_error").show();
									 $("label#uname_error").show(); 
									 return false;
								  }
								if(d1=="" && d2=="")
								  {
									$("label#fname_error").show(); 
									$("label#lname_error").show();  
									return false;
								  }
								if(d3=="" && d4=="")
								 {
									 $("label#email_error").show();
									 $("label#uname_error").show(); 
									 return false;
								 }
								if(d1=="" && d2=="")
								 {
                                  $("label#fname_error").show();
									 $("label#lname_error").show(); 
									 return false;
									 
								 }
								if(d4=="")
								{
									$("label#uname_error").show(); 
									return false;
								}
								
								if(d5=="")
									{
									$("label#pass_error").show(); 
									return false;
								}
								
								if(d1=="")
									{
									$("label#fname_error").show(); 
									return false;
								}
								
								if(d2=="")
									{
									$("label#lname_error").show(); 
									return false;
								}
								
								if(d3=="")
									{
									$("label#email_error").show(); 
									return false;
								}

								
						
							 var dataval="fname="+d1+"&lname="+d2+"&email="+d3+"&username="+d4+"&password="+d5;							 
							 //$('#loading').load('addoption.php');
							 //$('#question').attr('disabled','disabled');
                             //$('#sclass').attr('disabled','disabled');
							 //$('#scategory').attr('disabled','disabled');
							 //$('#marks').attr('disabled','disabled');
							  $.ajax(
									 {
										 url : 'adduser_process.php',
										 type:'POST',
										 data:dataval,
										 dataType : 'json',
										 success:function(xhr)
										   {
											  //alert(xhr);
											//$('#loading').html('<div id="optionval"><fieldset style="width:200px;"><legend><b>Add Options</b></legend><form name="addquestion" id="addquestion" method="post" action=""><input type="hidden" value="0" id="theValue"/><div id="myDiv"></div><p><a href="javascript:;" onClick="addoption();">Add Options</a></p><input type="submit" value="Submit" id="addoption" name="addoption" onClick="javascript:addoptionvalue();return false;"/><input type="button" value="cancel" onClick="getquestion(xhr)"/></form></fieldset><div id="answer"></div></div>');
											   //alert(json);
											//$('#examiner').fadeOut('slow').load('manage_users.php').fadeIn("slow");					
							   				//$('#students').load('index.php');
											location.reload();
											
										   }
										   
										
									 }
								  );
							  
						  }
						  //$('#myclass').load('addoption.php');
					 );	  			  								   
 }

 function submitstudents()
 {
   //var $j = jQuery.noConflict();	 
    $("#addstudent").click(function()
				          {
							 $('.error').hide();  
							 var d1=$('#fname').val();
                             var d2=$('#lname').val();
							 var d3=$('#email').val();
							 var d4=$('#phone').val();
							 var d5=$('#classname').val();
							 var d6=$('#rollno').val();
							 var d7=$('#branch').val();
							 var d8=$('#parentsno').val();
							   if(d1=="" && d2=="" && d3=="" && d4=="" && d5=="0" && d6=="" && d7=="" && d8=="")
							     {
									 $("label#fs_error").show();
									 $("label#ls_error").show();
									 $("label#e_error").show();
									 $("label#ph_error").show();
									  $("label#cl_error").show();
									 $("label#roll_error").show();
									  $("label#branch_error").show();
									 $("label#gn_error").show();
									 return false;
								 }
								if(d1=="" && d3=="" && d6=="" && d8=="")
								 {
									$("label#fs_error").show();
									$("label#e_error").show();
									$("label#roll_error").show();
									$("label#gn_error").show();
									return false; 
								 }
								if(d3=="" && d4=="" && d6=="" && d8=="") 
								{
									 $("label#e_error").show();
									 $("label#ph_error").show();
									 $("label#roll_error").show();
									 $("label#gn_error").show();
									 return false;
								}
								if(d1=="" && d3=="" && d4=="" && d6=="")
								{
									$("label#fs_error").show();
									$("label#e_error").show();
									$("label#ph_error").show();
									$("label#roll_error").show();
									return false;
								}
								if(d1=="" && d4=="" && d6=="" && d8=="")
								{
									$("label#fs_error").show();
									$("label#ph_error").show();
									$("label#roll_error").show();
									$("label#gn_error").show();
									return false;
								}
								if(d1=="" && d3=="" && d4=="" && d8=="")
								{
									$("label#fs_error").show();
									$("label#e_error").show();
									$("label#ph_error").show();
									$("label#gn_error").show();
								}
								if(d4=="" && d6=="" && d8=="")
								{
									 $("label#ph_error").show();
									 $("label#roll_error").show();
									 $("label#gn_error").show();
									 return false;
								}
								if( d6=="" && d8=="")
								{
									$("label#roll_error").show();
									$("label#gn_error").show();
									return false;
								}
								if(d8=="")
								{
								  $("label#gn_error").show();
								  return false;	
								}

								if(d7=="")
								{
								  $("label#branch_error").show();
								  return false;	
								}

								if(d6=="")
								{
								  $("label#roll_error").show();
								  return false;	
								}

								if(d5=="0")
								{
								  $("label#cl_error").show();
								  return false;	
								}

								if(d4=="")
								{
								  $("label#ph_error").show();
								  return false;	
								}

								if(d3=="")
								{
								  $("label#e_error").show();
								  return false;	
								}

								if(d2=="")
								{
								  $("label#ls_error").show();
								  return false;	
								}

								if(d1=="")
								{
								  $("label#fs_error").show();
								  return false;	
								}

								
							 var dataval="fname="+d1+"&lname="+d2+"&email="+d3+"&phone="+d4+"&classname="+d5+"&rollno="+d6+"&branch="+d7+"&parentsno="+d8;							 
							   //$('#loading').load('addoption.php');
							   //$('#question').attr('disabled','disabled');
                               //$('#sclass').attr('disabled','disabled');
							   //$('#scategory').attr('disabled','disabled');
							   //$('#marks').attr('disabled','disabled');
							  $.ajax(
									 {
										 url : 'addstudents_process.php',
										 type:'POST',
										 data:dataval,
										 dataType : 'json',
										 success:function(xhr)
										   {
											  //alert(xhr);
											//$('#loading').html('<div id="optionval"><fieldset style="width:200px;"><legend><b>Add Options</b></legend><form name="addquestion" id="addquestion" method="post" action=""><input type="hidden" value="0" id="theValue"/><div id="myDiv"></div><p><a href="javascript:;" onClick="addoption();">Add Options</a></p><input type="submit" value="Submit" id="addoption" name="addoption" onClick="javascript:addoptionvalue();return false;"/><input type="button" value="cancel" onClick="getquestion(xhr)"/></form></fieldset><div id="answer"></div></div>');
											   //alert(json);
											$('#students').fadeOut('slow').load('manage_students.php').fadeIn("slow");					
							   
										   }
										   
										
									 }
								  );
							  
						  }
						  //$('#myclass').load('addoption.php');
					 );	  			  								   
 }
 function addoption()
{
  var ni = document.getElementById('myDiv');
  var numi = document.getElementById('theValue0');
  var num = (document.getElementById('theValue0').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div';
  newdiv.setAttribute('id',divIdName);
  newdiv.innerHTML = '<div id="optionfor0"><div id="resultdisplay0"></div><input type="text" name="optionq0'+num+'" id="optionq0'+num+'" class="option"/>&nbsp;&nbsp;<input type="hidden" value="'+num+'" name="addoptionq0" id="addoptionq0"/>&nbsp;&nbsp;<input type="radio" id="optionr0'+num+'" name="optionr" class="optionr0" onclick=\"alertsay11('+num+');\" /><input type="file" name="ofile0'+num+'" id="ofile0'+num+'"/><a href="javascript:openNewEditor(\'optionq0'+num+'\', \'plain\',\'opt'+num+'\')">Launch Equation Editor</a><a href="#" onclick=\'removeoption("'+divIdName+'");\'><img src="images/but_delete.gif" border="0"/></a><br/> <br/><div id="answerid"></div></div><div id="opt'+num+'"></div>';
  ni.appendChild(newdiv);
  //num++;
  
}
function removeElement() 
 {
   var d=document.getElementById('divIdName');
   removeChild(d);
 }
 
function getquestion(value)
 {
	 
	 var TheTextBox=document.getElementById('addoption');
	 if(confirm('Are you sure you want to cancel this request? Changes cannot be undone.'))
     {
	    var myAjax = new Ajax.Request('deletequestion.php', 
               {method: 'post', parameters: {question_id:value},
			   onSuccess: function(transport)
	                {
					    if(transport.responseText)
						   {
								//alert(transport.responseText);
								TheTextBox.innerHTML=transport.responseText;
								
						   }
						else
						{
							 return false;
						}
                                 					
					}
			   });  
     }
    else
    {
        return false;	
    }
 }
 
 
 function getquestionOption(value)
 {
	 var TheTextBox=document.getElementById('addoption');
	 if(confirm('Are you sure you want to cancel this request? Changes cannot be undone.'))
     {
	    var myAjax = new Ajax.Request('deletequestionoption.php', 
               {method: 'post', parameters: {question_id:value},
			   onSuccess: function(transport)
	                {
					    if(transport.responseText)
						   {
								//alert(transport.responseText);
								TheTextBox.innerHTML=transport.responseText;
								
						   }
						else
						{
							 return false;
						}
                                 					
					}
			   });  
     }
    else
    {
        return false;	
    } 
 }
 
  function submitquestion()
 {
   //var $j = jQuery.noConflict();	 
    $("#addquestion").click(function()
				          {
							
                              
							 var d1=$('#question').val();
							 var d2=$('#sclass').val();
							 var d3=$('#scategory').val();
							 var d4=$('#marks').val();
							   if(d1=="" && d2=="0" && d3=="0" && d4=="") 
							     {
									 $("label#question_error").show(); 
									 $("label#sclass_error").show();
									 $("label#scategory_error").show();
									 $("label#marks_error").show(); 
                                    // $("#question").focus();  
                                     return false; 
								 }
								  if(d1=="" && d2=="0" && d3=="0")
								  {
									 $("label#question_error").show();
									 $("label#scategory_error").show();
									 $("label#sclass_error").show();
									 return false;
								 }
								 if(d1=="" && d3=="0" && d4=="")
								  {
									 $("label#question_error").show();
									 $("label#scategory_error").show();
									 $("label#marks_error").show();
									 return false;
								 }
								 
								 if(d2=="0" && d3=="0" && d4=="")
								  {
									 $("label#sclass_error").show();
									 $("label#scategory_error").show();
									 $("label#marks_error").show(); 
									 return false;
								  }
								  if(d1=="" && d2=="0" && d4=="")
								  {
									 $("label#question_error").show(); 
									 $("label#sclass_error").show();
									 $("label#marks_error").show(); 
									 return false;
								  }
								if(d1=="" && d2=="0")
								  {
									$("label#question_error").show(); 
									$("label#sclass_error").show();  
									return false;
								  }
								if(d3=="0" && d4=="")
								 {
									 $("label#scategory_error").show();
									 $("label#marks_error").show(); 
									 return false;
								 }
								if(d1=="" && d3=="0")
								 {
									$("label#question_error").show(); 
									$("label#scategory_error").show();
									return false;
								 }
								if(d2=="0" && d4=="")
								 {
									$("label#sclass_error").show();
									$("label#marks_error").show();
									return false;
								 }
								if(d1=="" && d4=="")
								 {
									$("label#question_error").show();
									$("label#marks_error").show();
									return false;
								 }
								 if(d3=="0" && d2=="0")
								 {
									 $("label#scategory_error").show();
									 $("label#marks_error").show();
								 }
								if(d4=="")
								{
									$("label#marks_error").show(); 
									return false;
								}
								
								
								  
							   				
								
							 var dataval="&question="+d1+"&sclass="+d2+"&scategory="+d3+"&marks="+d4 ;
							 //$('#loading').load('addoption.php');
							 //alert(dataval);
							 $('#question').attr('disabled','disabled');
                             $('#sclass').attr('disabled','disabled');
							 $('#scategory').attr('disabled','disabled');
							 $('#marks').attr('disabled','disabled');
							  $.ajax(
									 {
										 url : 'addquestions_process.php',
										 type:'POST',
										 data:dataval,
										 dataType : 'json',
										 success:function(data)
										   {
											  //alert(xhr);
											// $('#loading').html('<div id="optionval"><fieldset style="width:200px;"><legend><b>Add Options</b></legend><form name="addquestion" id="addquestion" method="post" action=""><input type="hidden" value="0" id="theValue"/><div id="myDiv"></div><p><a href="javascript:addoption();" >Add Options</a></p><input type="submit" value="Submit" id="addoption" name="addoption" onClick="javascript:addoptionvalue();return false;"/><input type="button" value="cancel" onClick="getquestion(xhr)"/></form></fieldset><div id="answer"></div></div>');                    
											 
												$('#loading').load("addoption.php");	
												
														
                                            						   
										   }
								 		   
										
									 }
								  );
							  
						  }
						  //$('#myclass').load('addoption.php');
					 );	  			  								   
 }
 
  function addoptionvalue()
 {
	//alert("Hi");
	$("#addoption").click(function()
							{
							  
							   var c=$('#optionval input[type="text"]').size();
							   var d='';
							   var ans=''; 						  
							   $('#optionval input[type="text"]').each(function()
															{
										 						d=d+$(this).val()+'@';
																											
															}
															
															
												
                                   );
							    $('#optionval input[type="radio"]').each(function(index)
																					{
																						
																						 if($(this).is(':checked'))
																						   {
																							   var d1=index+1;
																							   ans+=$('#option'+d1).val();
																							   
																						   }
																						  
																					}
																		);			
							    
							   var datas="count="+d+"&size="+c+"&answer="+ans;
							    $('#optionval input[type="text"]').attr('disabled','disabled');
							   $('#optionval input[type="radio"]').attr('disabled','disabled');
							   alert(datas);
							 	       $.ajax(
												   {
													 url:'addoption_process.php',
													 type:'POST',
													 data:datas,
													 dataType:'json',
													 success:function(xhr)
													   {
														 
														 														  
													   }
													 
												   }
												);
									   
							}
					);		
	  
 }
 
 function generatepaper2()
 {

	 
										
    $("#generatpaper123").click(function()
				          { 
		                    var d1=$('#papername').val();
							 var d2=$('#classname').val();
							 var d3=$('#categoryname').val();
							 var d4=$('#marks').val();
							  
											 $('.error').hide();
											var d1=$('#papername').val();
											var d2=$('#classname').val();
											var d3=$('#categoryname').val();
											var d4=$('#marks').val();
											  if(d1=="" && d2=="0" && d3=="0" && d4=="") 
											 {
											 $("label#pname_error").show(); 
											 $("label#cl_error").show();
									         $("label#cat_error").show();
									         $("label#mar_error").show(); 
									                                   
                                             return false; 
								             }
								
								 if(d1=="" && d3=="0" && d4=="" )
								  {
									 $("label#pname_error").show();
									 $("label#cat_error").show();
									 $("label#mar_error").show();
									
									 return false;
								 }
								 
								 if(d2=="0" && d3=="0" && d4=="")
								  {
									 $("label#cl_error").show();
									 $("label#cat_error").show();
									 $("label#mar_error").show(); 
									
									 return false;
								  }
								  if(d1=="" && d2=="0" && d4=="")
								  {
									 $("label#pname_error").show(); 
									 $("label#cat_error").show();
									 $("label#mar_error").show(); 
									 return false;
								  }
								if(d1=="" && d2=="0")
								  {
									$("label#pname_error").show(); 
									$("label#cl_error").show();  
									return false;
								  }
								if(d3=="0" && d4=="")
								 {
									 $("label#cat_error").show();
									 $("label#mar_error").show(); 
									 return false;
								 }
								if(d1=="" && d2=="0")
								 {
                                  $("label#pname_error").show();
									 $("label#cl_error").show(); 
									 return false;
									 
								 }
								if(d4=="")
								{
									$("label#mar_error").show(); 
									return false;
								}
								
							
								if(d1=="")
									{
									$("label#pname_error").show(); 
									return false;
								}
								
								if(d2=="0")
									{
									$("label#cl_error").show(); 
									return false;
								}
								
								if(d3=="0")
									{
									$("label#mar_error").show(); 
									return false;
								} 			
								
							 var dataval="&papername="+d1+"&classname="+d2;
							 //alert(dataval);
							// $('#loading').load('addoption.php');
							// $('#papername').attr('disabled','disabled');
                            // $('#classname').attr('disabled','disabled');
							// $('#categoryname').attr('disabled','disabled');
							// $('#marks').attr('disabled','disabled');
							  $.ajax(
									
									 {
										 url:'generatepaper_process.php',
										 type:'POST',
										 data:dataval,
										 dataType : 'json',
										 success:function(xhr)
										   {
											  alert(xhr);
											
											   //alert(json);
											//$('#loading1').load("addoption.php");		
											 //
                                            						   
										   }
								 		   
										

									 }
								  );
							   $('#loding1').load('generatepaper_process.php');
						  }
						 
					 );	  			  								   
 }
 
   function submitcategory()
 { 
 		
       $("#addcategories").click(function()
		{
		  
			var d1=$('#category').val();
				 							       
			  if(d1=="")
				  {
					  $("label#ca_error").show();
					  return false;
				  }

	                         var dataval="categories="+d1 ;
							 //alert(dataval);
							 //$('#loading').load('addoption.php');
							 //$('#question').attr('disabled','disabled');
                             //$('#sclass').attr('disabled','disabled');
							 //$('#scategory').attr('disabled','disabled');
							 //$('#marks').attr('disabled','disabled');
							  $.ajax(
									 {
										 url : 'addcategories_process.php',
										 type:'POST',
										 data:dataval,
										 dataType : 'json',
										 success:function(xhr)
										   {
											  //alert(xhr);
											//$('#loading').html('<div id="optionval"><fieldset style="width:200px;"><legend><b>Add Options</b></legend><form name="addquestion" id="addquestion" method="post" action=""><input type="hidden" value="0" id="theValue"/><div id="myDiv"></div><p><a href="javascript:;" onClick="addoption();">Add Options</a></p><input type="submit" value="Submit" id="addoption" name="addoption" onClick="javascript:addoptionvalue();return false;"/><input type="button" value="cancel" onClick="getquestion(xhr)"/></form></fieldset><div id="answer"></div></div>');
											   //alert(json);
											$('#categories').fadeOut('slow').load('manage_categories.php').fadeIn("slow");					
							   
										   }
										   
										
									 }
								  );
							   }
  );	
						 
						  //$('#myclass').load('addoption.php');
 }					 			  								   
 
/*$("#frmAdduser").validate({
alert("hhhh");
rules: {
category: {
required: true,
}
},
messages: {
category: "Please enter the Category."
}
});
});*/

 
 function submitclass()
 {
   //var $j = jQuery.noConflict();	 
    $("#addclass").click(function()
				          {
							 //$('.error').hide();		
							 var d1=$('#cla123').val();
							 
					         //alert(d1);
							  if(d1=="")
							  {
								  $("label#class_error").show();
								  return false;
							  }
							 var dataval="classes="+d1 ;							 
							 //$('#loading').load('addoption.php');
							 //$('#question').attr('disabled','disabled');
                             //$('#sclass').attr('disabled','disabled');
							 //$('#scategory').attr('disabled','disabled');
							 //$('#marks').attr('disabled','disabled');
							  $.ajax(
									 {
										 url : 'addclasses_process.php',
										 type:'POST',
										 data:dataval,
										 //dataType : 'json',
										 success:function()
										   {
											  alert('Data added successfully');

										   }
										   
										
									 }
								  );

								
							
							  
						  }
						  //$('#myclass').load('addoption.php');
					 );	  			  								   
 }

function checkcategory()
 {
	var d=$('#category').val();
	if(d=="")
	{
		$('#resultdisplay').html('please enter the category');
		return false;
	}
	else
	{
		$('#resultdisplay').html('');
	}
	
 }
 
 function checkclass()
 {
	 var d1=$('#cla123').val();
	   if(d1=="")
	     {
			 $('#resultdisply').html('Please enter class');
			 return false;
		 }
	   else
	   {
		   $('#resultdisplay').html('');
	   }
 }

function checkuser()
{
	var d1=$('#fname').val();
	var d2=$('#lname').val();
	var d3=$('#email').val();
	var d4=$('#username').val();
	var d5=$('#password').val();
	if(d1=="" && d2=="" && d3=="" && d4=="" && d5=="")
	{
		$('#r1').html('Please enter firstname');
		$('#r2').html('Please enter lastname');
		$('#r3').html('Please enter email');
		$('#r4').html('Please enter username');
		$('#r5').html('Please enter password');
		return false;
	}
	else 
	{  
	   $('#r1').html('');
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d2=="" && d3=="" && d4=="" && d5=="")
	{
		$('#r2').html('Please enter lastname');
		$('#r3').html('Please enter email');
		$('#r4').html('Please enter username');
		$('#r5').html('Please enter password');
		return false;
	}
	else 
	{  
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d3=="" && d4=="" && d5=="")
	{
		$('#r3').html('Please enter email');
		$('#r4').html('Please enter username');
		$('#r5').html('Please enter password');
		return false;
	}
	else 
	{  
	   $('#r3').html('');
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d4=="" && d5=="")
	{
		
		$('#r4').html('Please enter username');
		$('#r5').html('Please enter password');
		return false;
	}
	else 
	{  
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d5=="")
	{
		$('#r5').html('Please enter password');
		return false;
	}
	else
	{
		$('#r5').html('');
	}
	
	   if(d1=="")
	     {
			$('#r1').html('Please enter firstname');
			 return false; 
		 }
	   else
	   {
		    $('#r1').html('');
	   }
	   if(d2=="")
	   {
		  $('#r2').html('Please enter lastname');
		  return false;  
	   }
	   else
	   {
		   $('#r2').html(''); 
	   }
	   if(d3=="")
	    {
		  $('#r3').html('Please enter email');
		  return false;  
	   }
	   else
	   {
		   $('#r3').html(''); 
	   }
	   if(d4=="")
	    {
		  $('#r4').html('Please enter username');
		  return false;  
	   }
	   else
	   {
		   $('#r4').html(''); 
	   }
	   if(d5=="")
	   {
		  $('#r5').html('Please enter password');
		  return false;  
	   }
	   else
	   {
		   $('#r5').html('');  
	   }
	   
}

function checkstudents()
{
	var d1=$('#fname').val();
	var d2=$('#email').val();
	var d3=$('#phone').val();
	var d4=$('#rollno').val();
	var d5=$('#parentsno').val();
	if(d1=="" && d2=="" && d3=="" && d4=="" && d5=="")
	{
		$('#r1').html('Please enter firstname');
		$('#r2').html('Please enter email address');
		$('#r3').html('Please enter phone number');
		$('#r4').html('Please enter roll number');
		$('#r5').html('Please enter parents number');
		return false;
	}
	else 
	{  
	   $('#r1').html('');
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d2=="" && d3=="" && d4=="" && d5=="")
	{
		$('#r2').html('Please enter email address');
		$('#r3').html('Please enter phone number');
		$('#r4').html('Please enter roll number');
		$('#r5').html('Please enter parents number');
		return false;
	}
	else 
	{  
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d3=="" && d4=="" && d5=="")
	{
		$('#r3').html('Please enter phone number');
		$('#r4').html('Please enter roll number');
		$('#r5').html('Please enter parents number');
		return false;
	}
	else 
	{  
	   $('#r3').html('');
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d4=="" && d5=="")
	{
		
		$('#r4').html('Please enter roll number');
		$('#r5').html('Please enter parents number');
		return false;
	}
	else 
	{  
	   $('#r4').html('');
	   $('#r5').html('');
	}
	if(d5=="")
	{
		$('#r5').html('Please enter parents number');
		return false;
	}
	else
	{
		$('#r5').html('');
	}
	   if(d1=="")
	     {
			$('#r1').html('Please enter firstname');
			 return false; 
		 }
	   else
	   {
		    $('#r1').html('');
	   }
	   if(d2=="")
	   {
		  	$('#r2').html('Please enter email address');
		  return false;  
	   }
	   else
	   {
		   $('#r2').html(''); 
	   }
	   if(d3=="")
	    {
		 $('#r3').html('Please enter phone number');
		  return false;  
	   }
	   else
	   {
		   $('#r3').html(''); 
	   }
	   if(d4=="")
	    {
		  $('#r4').html('Please enter roll number');
		  return false;  
	   }
	   else
	   {
		   $('#r4').html(''); 
	   }
	   if(d5=="")
	   {
		 $('#r5').html('Please enter parents number');
		  return false;  
	   }
	   else
	   {
		   $('#r5').html('');  
	   }
	
}

function checkpaper()
{
	
	var d1=$('#papername').val();
	var d2=$('#categoryname').val();
	var d3=$('#classname').val();
	var d4=$('#marks').val();
	
	if(d1=="" && d2=="0" && d3=="0" && d4=="")
	{
		$('#r1').html('Please enter paper name');
		$('#r2').html('Please enter category name');
		$('#r3').html('Please enter class name');
		$('#r4').html('Please enter marks');
		return false;
	}	
	else 
	{  
	   $('#r1').html('');
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
	   
	}
	if(d2=="0" && d3=="0" && d4=="")
	{
		$('#r2').html('Please enter category name');
		$('#r3').html('Please enter class name');
		$('#r4').html('Please enter marks');
		return false;
	}
	else 
	{  
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
  	}
	if(d3=="0" && d4=="" )
	{
	    $('#r3').html('Please enter class name');
		$('#r4').html('Please enter marks');
		return false;
	}
	else 
	{  
	   $('#r3').html('');
	   $('#r4').html('');
	   
	}
	if(d4=="")
	{
		$('#r4').html('Please enter marks');
		return false;
	}
	else
	{
		$('#r4').html('');
	}
	if(d1=="")
	{
	   $('#r1').html('Please enter paper name');
	   return false;
	}
	else
	{
		$('#r1').html('');
	}
	if(d2=="0")
	{
	   $('#r2').html('Please enter category name');
	   return false;
	}
	else
	{
		$('#r2').html('');
	}
	if(d3=="0")
	{
	   $('#r3').html('Please enter class name');
	   return false;
	}
	else
	{
		$('#r3').html('');
	}
	if(d4=="")
	{
	   $('#r4').html('Please enter marks');
	   return false;
	}
	else
	{
		$('#r4').html('');
	}  
	  
}

function checkshedular()
{
	var d1=$('#paper').val();
	var d2=$('#start_time').val();
	var d3=$('#end_time').val();
	
	if(d1=="0" && d2=="" && d3=="")
	  {
		$('#r1').html('Please enter paper name');
		$('#r2').html('Please enter start time');
		$('#r3').html('Please enter end time');
		return false;
	  }
	  else
	  {
		$('#r1').html('');
		$('#r2').html('');
		$('#r3').html('');
	  }
	  if(d2=="" && d3=="")
	  {
		$('#r2').html('Please enter start time');
		$('#r3').html('Please enter end time');
		return false;
	  }
	  else
	  {
		$('#r2').html('');
		$('#r3').html('');
	  }
	  if(d1=="0")
	  {
		  $('#r1').html('Please enter paper name');
		  return false;
	  }
	  else
	  {
		 $('#r1').html('');  
	  }
	   if(d2=="")
	  {
		 $('#r2').html('Please enter start time');
		  return false;
	  }
	  else
	  {
		 $('#r2').html('');  
	  }
	    if(d3=="")
	  {
		$('#r3').html('Please enter end time');
		  return false;
	  }
	  else
	  {
		 $('#r3').html('');  
	  }
}

function checkquestion()
{
	var d1=$('#question"').val();
	var d2=$('#sclass').val();
	var d3=$('#scategory').val();
	var d4=$('#marks').val();
	
	if(d1=="" && d2=="" && d3=="" && d4=="" )
	{
		$('#r1').html('Please enter question');
		$('#r2').html('Please enter class name');
		$('#r3').html('Please enter category name');
		$('#r4').html('Please enter marks');
		return false;
	}	
	else 
	{  
	   $('#r1').html('');
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
	   
	}
	if(d2=="" && d3=="" && d4=="")
	{
		$('#r2').html('Please enter class name');
		$('#r3').html('Please enter category name');
		$('#r4').html('Please enter marks');
		return false;
	}
	else 
	{  
	   $('#r2').html('');
	   $('#r3').html('');
	   $('#r4').html('');
  	}
	if(d3=="" && d4=="" )
	{
	    $('#r3').html('Please enter category name');
		$('#r4').html('Please enter marks');
		return false;
	}
	else 
	{  
	   $('#r3').html('');
	   $('#r4').html('');
	   
	}
	   if(d1=="")
	     {
			$('#r1').html('Please enter question');
			 return false; 
		 }
	   else
	   {
		    $('#r1').html('');
	   }
	   if(d2=="")
	   {
		  $('#r2').html('Please enter class name');
		  return false;  
	   }
	   else
	   {
		   $('#r2').html(''); 
	   }
	   if(d3=="")
	    {
		 $('#r3').html('Please enter category name');
		  return false;  
	   }
	   else
	   {
		   $('#r3').html(''); 
	   }
	   if(d4=="")
	    {
		  $('#r4').html('Please enter roll number');
		  return false;  
	   }
	   else
	   {
		   $('#r4').html(''); 
	   }
}

function alertsay()
{
	 $('#optionval input[type="radio"]').each(function(index)
																					{
		                                                                                
																						
																						 if($(this).is(':checked'))
																						   {
																							   var d1=index+1;
																							   //alert(d1);
																							   //ans+=$('#option'+d1).val();
																							   $('#answerid').html('<input type="hidden" name="answerid" value="'+d1+'"/>');
																							   
																						   }
																						  
																					}
																		);
	 
}


function checkoption123()
{
	var count= $('#optionval input[type="text"]').size();
    var i=count;
	var j=1;
	  for(i=1;i<=count;i++)
	      {
		     for(j=1;j<i;j++)
			  {
				 
				
				 var d1=$('#option'+i).val();
				 var d2=$('#option'+j).val();
				 //alert(d1);
				 //alert(d2);
				 if(d1==d2)
				  {
					 alert("options are same.please enter another option");
					 return false;
				  }
                 			  }
          }

}

function recordClass(frm){
	
	var d = document.getElementById('marks');
	d.innerHTML	=	'&nbsp;&nbsp;&nbsp;<img src="images/progress.gif">';
	//d.innerHTML	=	'Loading...';
	var file	=	'generate.php';
	var myAjax = new Ajax.Request(file, 
                                   {method: 'post', parameters: $(frm).serialize(), 
                                   onSuccess: function(transport){ //alert(transport.responseText)
										   	 if(transport.responseText){
												d.innerHTML=transport.responseText;
												$('AddsentItem').disabled=false; 
											 }else{
												 return false;
											 }
											 
										 }
										});

	}
 
function addquestion()
{ //reloadMCE();
  var ni = document.getElementById('myQues');
  var numi = document.getElementById('theQuestion');
  var num = (document.getElementById('theQuestion').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div';
  newdiv.setAttribute('id',divIdName);
  newdiv.innerHTML = '<fieldset><table border="0" width="100%"><tr><td colspan="2"><a id="deletequestion'+num+'" href="#" onclick=\'removeQuestion("'+divIdName+'");\'><img align="right" src="images/but_delete.gif" border="0"/></a></td></tr><tr><td colspan="2"><table width="100%" border="1"> <tr> <td width="50%"><textarea name="question'+num+'" id="question'+num+'" rows="20" cols="50"></textarea></td> <td align="center"><a href="javascript:openNewEditor(\'question'+num+'\')">Launch Equation Editor</a><br/> <br/> </td> </tr> </table><div id="rq'+num+'"></div></td></tr><tr><td>Marks&nbsp;:&nbsp;<input type="text" name="marks'+num+'" id="marks'+num+'"/></td><td><div id="rm'+num+'"></div></td></tr><tr><td><input type="hidden" value="0" id="theValue'+num+'"/><div id="myDiv'+num+'"></div><a href="javascript:addoption1('+num+');">Add Options</a></td></tr><tr><td><input type="hidden" name="questionid" id="questionid" value="'+num+'"/></td></tr></table></fieldset>';
  ni.appendChild(newdiv);
  //reloadMCE();
}

function removeQuestion(id)
{
	 var d = document.getElementById('myQues');
     var olddiv = document.getElementById(id);
	 d.removeChild(olddiv);
	
}

function addoption1(n1)
{
	
  var ni1 = document.getElementById('myDiv'+n1);
  
  var numi = document.getElementById('theValue'+n1);
  var num = (document.getElementById('theValue'+n1).value -1)+ 2;
  numi.value = num;
  var newdiv1 = document.createElement('div');
  //alert(num);
  var divIdName = 'quesopt'+n1+num;
  //alert('opt'+n1+''+num);
  newdiv1.setAttribute('id',divIdName);
  newdiv1.innerHTML = '<div id="resultdisplay'+n1+'"></div><input type="text" name="optionq'+n1+''+num+'" id="optionq'+n1+''+num+'" class="option"/>&nbsp;&nbsp;<input type="hidden" value="'+num+'" name="addoptionq'+n1+'" id="addoptionq'+n1+'"/>&nbsp;&nbsp;<input type="radio" id="optionr'+n1+''+num+'" name="optionr'+n1+'" class="optionr"  onclick="alertsay1('+n1+','+num+');" /><input type="file" name="ofile'+n1+''+num+'" id="ofile'+n1+''+num+'"/><a href="javascript:openNewEditor(\'optionq'+n1+''+num+'\', \'plain\', \'opt'+n1+''+num+'\')">Launch Equation Editor</a><a href="#" onclick=\'removeme("'+n1+'","'+divIdName+'");\'><img src="images/but_delete.gif" border="0"/></a><div id="answerid'+n1+'"></div><div id="opt'+n1+''+num+'"></div>';
  //prompt("", newdiv1.innerHTML);
  ni1.appendChild(newdiv1);
 
}

function removeme(n,id)
{ 
   var d=document.getElementById('myDiv'+n);
   var olddiv = document.getElementById(id);
   d.removeChild(olddiv);
}


function alertsay1(num,n2)
{
	//alert("Hi");
	//$('#answerid'+num).html('<input type="text" name="answerid'+num+'" value="'+n2+'"/>');
	document.getElementById('answerid'+num).innerHTML='<input type="hidden" name="answerid'+num+'" value="'+n2+'"/>';
}

function alertsay11(n2)
{
	// alert("hi");
	//$('#answerid').html('<input type="text" name="answerid0" value="'+n2+'"/>');
	document.getElementById('answerid').innerHTML='<input type="hidden" name="answerid0" value="'+n2+'"/>'; 
}

function submitquescheck()
{
	
	var d1=$('#sclass').val();
	//alert(d1);
	var d2=$('#scategory').val();
	//alert(d2);
	var d=$('#theQuestion').val();	
	// var q1=tinyMCE.get('#question0').getContent();
	//alert(d1);
	
	for(var j=0;j<=d;j++)
		    { 
			
	 var q1=tinyMCE.get('question'+j).getContent();
	 //alert(q1);
	 //var q1=$('#question'+j).val();
			var m1=$('#marks'+j).val();
				var count=$('#theValue'+j).val();
				if(m1=="" && d1=="0" && d2=="0")
						{
							// $('#rq'+j).html('Please enter the Questions');
							 $('#rs1').html('Please enter the class');
							 $('#rs2').html('Please enter the category');
							 $('#rm'+j).html('Please enter the Marks');
						}
					   else
						 {
							 $('#rm'+j).html(''); 
							 $('#rs1').html('');
							 $('#rs2').html('');
						 }
						 if(q1=="" && m1=="")
						 {
							 $('#rq'+j).html('Please enter the Questions');
							 $('#rm'+j).html('Please enter the Marks');
							 return false;
						 }
					  else
						{ 
							 $('#rq'+j).html('');
							 $('#rm'+j).html('');
						}
						 if(q1=="")
						 {
							 $('#rq'+j).html('Please enter the Questions');
							 return false;
						 }
					  else
						{ 
							 $('#rq'+j).html('');
							 
						}
						
						if(m1=="")
						{
							$('#rm'+j).html('Please enter the Marks');
							return false;
						}
					  else
						{
							$('#rm'+j).html('');
						}
						
						
					var radio_check=0;
					  for(var s1=1;s1<=count;s1++)
						 {
							  
							 //alert(s1+"hi"); 
							var d8=$('#optionr'+j+''+s1);
							if(d8.is(':checked'))
								 {
								   //alert("Yes");	 
								   radio_check++;
								 }
							   else
								 {
									//alert("No"); 
								 }
														
						 }
						 
					if(radio_check>0)
				     {
						
					 }
					 else
					 {
						alert("Please select the options for question"+j);
						return false; 
					 }
										
					
	           							 			

						
						
						    for(var k=count;k>1;k--)
							  {
								    for(var x=1;x<k;x++)
									   {
										    var d8=$('#optionq'+j+''+k).val();
				                            var d9=$('#optionq'+j+''+x).val();
											//alert(d8);
											//alert(d9);
											  if(d8=="" && d9=="")
											  {
												  
											  }
											  else
											  {
												  
													  if(d8==d9)
														{
															//$('#resultdisplay'+j).html('Two options are same');
															alert('Two options are same');
															return false;
														}
													  else
														{
															//$('#resultdisplay'+j).html('');
														}
												  
											  }
									   }
									   
							  }
							  
						 
						 
			}
}

function recordpaper(frm){
	
	var d = document.getElementById('paper_name');
	d.innerHTML	=	'&nbsp;&nbsp;&nbsp;<img src="images/progress.gif">';
	//d.innerHTML	=	'Loading...';
	var file	=	'dis.php';
	var myAjax = new Ajax.Request(file, 
                                   {method: 'post', parameters: $(frm).serialize(), 
                                   onSuccess: function(transport){ //alert(transport.responseText)
										   	 if(transport.responseText){
												d.innerHTML=transport.responseText;											
											 }else{
												 return false;
											 }
											 
										 }
										});

	}
 

 function recordClass(frm){
	
	var d = document.getElementById('marks');
	d.innerHTML	=	'&nbsp;&nbsp;&nbsp;<img src="images/progress.gif">';
	//d.innerHTML	=	'Loading...';
	var file	=	'generate.php';
	var myAjax = new Ajax.Request(file, 
                                   {method: 'post', parameters: $(frm).serialize(), 
                                   onSuccess: function(transport){ //alert(transport.responseText)
										   	 if(transport.responseText){
												d.innerHTML=transport.responseText;
												//alert(transport.responseText);
												$('AddsentItem').disabled=false; 
											 }else{
												 return false;
											 }
											 
										 }
										});

	}

function cancelme()
{
	$('#addquestionform').hide();
	location.reload();
}

function cancelclass()
{
	$('#addclassesform').hide();
	location.reload();
}

function cancelcategory()
{
	$('#addcategoryform').hide();
	location.reload();
}

function canceluser()
{
	 $('#adduserform').hide();
	 location.reload();
}
function cancelstudent()
{
	$('#addstudentsform').hide();
	location.reload();
}
function cancelpaper()
{
	$('#addgenerate').hide();
	location.reload();
}

function cancelschdular()
{
	 $('#paper').hide();
	 location.reload();
}

