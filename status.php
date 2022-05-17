<?php
	require_once("php/constants.php");
	$connected = @fsockopen(PING, 80);
  	if($connected){
    	setcookie('status',"Online",time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
    	echo'<button class="btn btn-success status">Device/Server Online</button>';
  	}else{
	    setcookie('status',"Offline",time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
    	echo'<button class="btn btn-warning status">Device/Server Offline</button>';
  	}
?>