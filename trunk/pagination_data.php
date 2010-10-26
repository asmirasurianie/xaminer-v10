<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include('includes/connect.php');
$per_page = 9;

//Calculating no of pages
$sql = "select * from students";
$result = mysql_query($sql);
$count = mysql_num_rows($result);
$pages = ceil($count/$per_page)
?>

<script type="text/javascript" src="js/jquery-1.2.6.min"></script>
<script type="text/javascript" src="js/jquery_pagination.js"></script>

<div id="loading" ></div>
<div id="content" ></div>
<ul id="pagination">

<?php
//Pagination Numbers
for($i=1; $i<=$pages; $i++)
{
echo '<li id="'.$i.'">'.$i.'
}
?>
</ul>
</body>
</html>