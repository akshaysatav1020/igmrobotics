<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font.css">
  </head>
  <body>
    <?php

      if($_POST!=null){

      }else{
      	echo "string";
      //  die("Get not allowed!!!<br/><br/><button class='btn btn-md btn-success'>Home</button>");
      }

      class UpdateDBVersion{

        function __construct(){

        }
        function updateDBVersion($version){
          $feed = file_get_contents('../data.xml');
      		$xml = simplexml_load_string($feed);
          $xml->dbversion = $version;
          //echo $xml->dbversion;
          $xml->asXML('../data.xml');
          return true;
        }
        function getDBVersion(){
          $feed = file_get_contents('../data.xml');
      		$xml = simplexml_load_string($feed);
          return $xml->dbversion;
        }

      }

    ?>
    <script src="../js/jquery/jquery-3.2.1.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/jquery/jquery.cookie.js" charset="utf-8" type="text/javascript"></script>
    <script src="../js/bootstrap/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
  </body>
</html>
