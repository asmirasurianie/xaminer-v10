<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tiny.js"></script>

</script>
</head>

<body>
<?php $num=$_REQUEST['num']; 
echo '<textarea name="question'.$num.'" id="question'.$num.'" rows="15" cols="80" style="width: 80%"></textarea><div id="rq'.$num.'">';
?>
</body>
</html>
