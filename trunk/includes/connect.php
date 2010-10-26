<?php
$localhost = 'localhost';
$user = 'root';
$password = '';
$db = 'xaminer';

$link = mysql_connect($localhost, $user, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';


$db_selected = mysql_select_db($db, $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

?>