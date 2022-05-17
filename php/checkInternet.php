<?php
$connected = @fsockopen("www.igmrobotics.com", 80);//website, port  (try 80 or 443)
if ($connected){
    $is_conn = true; //action when connected
    fclose($connected);
    echo "Online";
}else{
    $is_conn = false; //action in connection failure
	echo "Offline";
}
    
?>