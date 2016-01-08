<?php
$curtimestamp = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
$lp1 = mktime(12, 0, 0, 6, 28, 2010);
$lp2 = mktime(0, 0, 0, 7, 12, 2010);
$lp3 = mktime(0, 0, 0, 7, 19, 2010);
echo $curtimestamp."<br>".$lp1."<br>".$lp2."<br>".$lp3;
?> 