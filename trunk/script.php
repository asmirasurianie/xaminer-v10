<?php
echo "<br><br>";    
$raw_data = $GLOBALS['HTTP_RAW_POST_DATA'];  
 parse_str( $raw_data, $_POST );

//test 1
var_dump($raw_data);
echo "<br><br>":
//test 2
print_r( $_POST );  
?>
