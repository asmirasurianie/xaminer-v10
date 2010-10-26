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
if($_GET)
{
$page=$_GET['page'];
}

$start = ($page-1)*$per_page;
$sql = "select * from students order by std_id limit $start,$per_page";
$result = mysql_query($sql);
?>
<table width="800px">
<?php
while($row = mysql_fetch_array($result))
{
$msg_id=$row['std_id'];
$message=$row['first_name'];
?>
<tr>
<td><?php echo $msg_id; ?></td>
<td><?php echo $message; ?></td>
</tr>
<?php
}
?>
</table>

</body>
</html>