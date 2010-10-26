//var $ = jQuery.noConflict();	 
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
  var numi = document.getElementById('theValue');
var num=0;
  var num = num+1
alert(num);
  numi.value = num;
  var numgh=1;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div';
  newdiv.setAttribute('id',divIdName);
  newdiv.innerHTML = '<input type="text" name="option[]" id="option[]" class="option"/>&nbsp;&nbsp;<input type="radio" id="optionr[]" name="optionr[]" class="optionr"/><br><br>';
  ni.appendChild(newdiv);
  num++;
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
	
	var d1=$('#papername1').val();
	var d2=$('#classname1').val();
	var d3=$('#categoryname1').val();
	var d4=$('#marks1').val();
	
	if(d1=="" && d2=="0" && d3=="0" && d4=="" )
	{
		$('#r1').html('Please enter paper name');
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
	if(d2=="0" && d3=="0" && d4=="")
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
	if(d3=="0" && d4=="" )
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
	   $('#r2').html('Please enter class name');
	   return false;
	}
	else
	{
		$('#r2').html('');
	}
	if(d3=="0")
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