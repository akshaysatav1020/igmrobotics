<?php
  require("constants.php");
  ini_set("display_errors",0);
  class DB{  
    function __construct(){
      try{
        //$this->conn = new mysqli("localhost", "root", "root", "igmp2");
        $connected = @fsockopen(PING, 80); 
        if($connected){
          setcookie('status',"Online",time()+7*24*60*60,"/",$_SERVER['SERVER_NAME']);
          $this->conn = new mysqli(HOST, USER, PASSWORD, DB);
          //$this->conn = new mysqli("localhost", "root", "root", "igm");
        }else{
          setcookie('status',"Offline",time()+7*24*60*60,"/",$_SERVER['SERVER_NAME']);
          $this->conn = new mysqli(LOCALHOST, LOCALUSER, LOCALPASSWORD, LOCALDB); 
        }
      }catch(PDOException $e){
        
      }
    }

    function getConnection(){
        return $this->conn;
    }

    function closeConnection(){
      echo "Connection Closed";
    }
  }  
?>