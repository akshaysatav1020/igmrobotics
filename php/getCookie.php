<?php
 // echo isset($_COOKIE["usermail"])?"PRESENT":"NOT";
 $text = `ifconfig`;
preg_match('/([0-9a-f]{2}:){5}\w\w/i', $text, $mac);
$mac = $mac[0];
echo $mac;
?>
