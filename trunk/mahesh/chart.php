<?php
/*************************************************
 * Micro Bar Chart
 *
 * Version: 1.0
 * Date: 2007-09-12
 *
 * Usage:
 *    include chart.php file into your source code.
 *    Fill the $data array with your values and call
 *    the drawChart function with this array.
 *    See the example index.php file.
 *
 ****************************************************/

function drawChart($chartData){
   global $tableSize, $chartTitle1, $chartTitle2;
   $maxValue = 0;

   // First get the max value from the array
   foreach ($chartData as $item) {
      if ($item['value'] > $maxValue) $maxValue = $item['value'];
   }

   // Now set the theoretical maximum value depending on the maxValue
   $maxBar = 1;
   while ($maxBar < $maxValue) $maxBar = $maxBar * 10;

   // Calculate 1px value as the table is 300px
   $pxValue = ceil($maxBar/$tableSize);

   // Now display the table with bars
   echo '<table class="graph"><tr><th align="left">'.$chartTitle1.'</th><th colspan="2" align="left">'.$chartTitle2.'</th></tr>';
   foreach ($chartData as $item) {
      $width = ceil($item['value']/$pxValue);
   	echo '<tr><td width="300px" nowrap>'.$item['title'].'</td>';
   	echo '<td width="'.($maxBar*$pxValue).'">
   	     <img src="style/barbg.gif" alt="'.$item['title'].'" width="'.$width.'" height="24" /></td>';
   	echo '<td>'.$item['value'].'</td></tr>';
   }
   echo '</table>';

}

?>