/* CodeCogs Commercial Software
   Copyright (C) 2004-2010 CodeCogs, Zyba Ltd, Broadwood, Holford, TA5 1DU, England.
   This software is licensed for commercial usage using version 2 of the CodeCogs Commercial Licence.
	 You must read this License (available at www.codecogs.com) before using this software.
   If you distribute this file it is YOUR responsibility to ensure that all
   recipients have a valid number of commercial licenses. You must retain a
   copy of this licence in all copies you make.
   This program is distributed WITHOUT ANY WARRANTY; without even the implied
   warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
   See the CodeCogs Commercial Licence for more details.
*/
var editorwindow = null;
var lasteditormode = null;

function Get_Cookie(name) {
  var start = document.cookie.indexOf(name+"=");
  var len = start+name.length+1;
  if ((!start) && (name != document.cookie.substring(0,name.length))) return null;
  if (start == -1) return null;
  var end = document.cookie.indexOf(";",len);
  if (end == -1) end = document.cookie.length;
  return unescape(document.cookie.substring(len,end));
}

function Set_Cookie(name,value,expires) {
  var cookieString = name + "=" +escape(value) + ( (expires) ? ";expires=" + expires.toGMTString() : "");
  document.cookie = cookieString;
}

function OpenLatexEditor(target,mode,language,inline,latex) 
{
	var url='http://latex.codecogs.com/editor_json.php?target='+target+'&type='+mode;
  if(language!='') url+='&lang='+language;
	if(inline==true) url+='&inline';
	
	if (typeof(latex) != 'undefined')
	{ 
		latex=latex.replace(/\+/g,'&plus;');
	  url+='&latex='+encodeURIComponent(latex);
	} else latex='';
	
  // check to see if open editor compatible with new request
  if(lasteditormode!=url)
	{
	  lasteditormode=url;
		if(editorwindow!=null) editorwindow.close();
		editorwindow=null;
	}
	
	var SID=Get_Cookie('eqeditor'); // sessionID
	var d=new Date(); 
	if (!SID)	SID=d.getTime()+Math.random();
	var expires=new Date(d.getTime()+(1000*3600*24*30)); 
	Set_Cookie('eqeditor',SID, expires);
	url+='&sid='+SID;
	
  if (editorwindow==null || editorwindow.closed || !editorwindow.location) 
	{
		editorwindow=window.open('','LaTexEditor','width=700,height=450,status=1,scrollbars=yes,resizable=1');
		if (!editorwindow.opener) editorwindow.opener = self;
	  editorwindow.document.write('<html><script src="'+url+'" type="text/javascript"></script><body></body></html>');
	}
	else
  	if (window.focus) editorwindow.focus();
}



var newEditor;
var localField = 'question0';
var localFieldType = 'rte';
var imgshow;
function showImg(){
	//alert("");
	var imgObj = document.getElementById(imgshow);
	var targetObj = document.getElementById("testbox");
	// prompt("", targetObj.value);
	if(document.getElementById(imgshow)!=null)
	imgObj.innerHTML = targetObj.value;
	
	if (localFieldType == 'rte')
		tinyMCE.get(localField).setContent(targetObj.value);
	else
		document.getElementById(localField).value=targetObj.value;

	newEditor.close();
}

function openNewEditor(fieldName, fieldType, imageshow){
	var targetObj = document.getElementById("testbox");
	targetObj.value="";
	if (fieldName != undefined)
		localField = fieldName;
	else
		localField =  'question0';

	if (fieldType != undefined)
		localFieldType = fieldType;
	else
		localFieldType =  'rte';
imgshow=imageshow;
	newEditor = window.open('', 'functionEditor', 'width=700px,height=450px,status=0,scrollbars=no,resizable=0');
	newEditor.document.write("<html><script type=\"text/javascript\">var mySetterField = 'testbox';</script><script src=\"js/editorCode.js\" type=\"text/javascript\"></script><body></body></html>");	
}


