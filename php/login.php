<?php
  //ini_set('max_execution_time', 300);
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '../phplibraries/phpmailer/src/Exception.php';
  require '../phplibraries/phpmailer/src/PHPMailer.php';
  require '../phplibraries/phpmailer/src/SMTP.php';
  require_once "db.php";
  //print_r($_POST);
  if($_POST!=null){

      //companyname, companyaddress, contactper1, contactper2, contactpri, contactpsec, emailpri, emailsec
      $db = new DB();
      $login = new Login();

      //$connection = $db->getConnection();
      if(isset($_POST["login"])){
        //$connection = new mysqli(HOST, USER, PASSWORD, DB);
        //$v = $login->checkAppVersion();
        //echo $v;
        //if($v=="updated"){
          $login->checkLogin($db->getConnection(), $_POST["uname"], $_POST["password"]);        
        //}else{
          //echo "Update";
        //}
      }else if(isset($_POST["passwordreset"])){
        //$login->forgetPassword($db->getConnection(), $_POST["uname"]);
        if($login->forgetPassword($db->getConnection(), $_POST["uname"])){
          echo "true";
        }else{
          echo "false";
        }
      }else if(isset($_POST["verifyotp"])){
        if($login->verifyOTP($db->getConnection(), $_POST["uname"], $_POST["otp"])){
          echo "true";
        }else{
          echo "false";
        }
      }else if(isset($_POST["updatepassword"])){
        if($login->updatePassword($db->getConnection(), $_POST["uname"], $_POST["password"])){
          echo "true";
        }else{
          echo "false";
        }
      }
  }else{
    $login = new Login();
    
    if(isset($_GET["logout"])){    
      $login->logout($_GET);      
    }
  }

  class Login{

    function checkLogin($connection, $uname, $password){
      $q = <<<EOD
      SELECT * FROM `user` WHERE `uname` = ? AND `password` = ?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ss",  $uname, $password);
      $uname = $_POST["uname"];
      $password = $_POST["password"];
      $stmt->execute();
      $result = $stmt->get_result();
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          /*$data[] = array('id'=>$row['id'],'email'=>$row['email'], 'role'=>$row['role'], 'active'=>$row['active'], 'approved'=>$row['approved']);*/
          setcookie('userid',$row["id"],time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
          setcookie('userId',$row["id"],time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
          setcookie('usermail',$row["email"],time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
          setcookie('userrole',$row["role"],time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
          setcookie('rack',"8",time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);
          setcookie('floor',"5",time()+7*24*60*60,'/',$_SERVER['SERVER_NAME']);

        }
        echo"success";
      }      
    }

    function getVendors($connection){
      $query="SELECT * FROM vendors";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'vno'=>$row['vno'],'company'=>$row['company_name']);
        }
      }
      setcookie("vendors",json_encode($data), time() + 86400,"/","127.0.0.1");
      if(self::getCustomers($connection)){
        return true;
      }
    }

    function getCustomers($connection){
      $query="SELECT * FROM customers";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'cno'=>$row['cno'],'company'=>$row['company_name']);
        }
      }
      setcookie("customers",json_encode($data), time() + 86400,"/","127.0.0.1");
      // if(self::getParts($connection)){
        return true;
      // }
    }

    function getParts($connection){
      $query="SELECT * FROM inventory_parts";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id']);
        }
      }
      setcookie("parts",json_encode($data), time() + 86400,"/","127.0.0.1");
      return true;
    }

    function forgetPassword($connection, $uname){
      $query="SELECT * FROM user WHERE uname = '".$uname."'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = $row['email'];
        }
      }
      $to = $data[0];
      $otp = self::generateRandomString(5);
      //echo $to."-----------------".$otp;
      $q = <<<EOD
      UPDATE user
      SET
      otp=?
      WHERE
      uname=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ss", $otp1, $uname1);
      $otp1 = $otp;
      $uname1 = $uname;
      if($stmt->execute()){
        if(self::sendMail($to, $otp)){
          return true;
        }
      }else{
        return false;
      }

    }

    function sendMail($to, $otp){
      $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
      try {
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        //$mail->Host = 'sg2plcpnl0171.prod.sin2.secureserver.net';  // Specify main and backup SMTP servers
        $mail->Host = MAILHOST;
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'akshay@metroservisol.com';                 // SMTP username
        //$mail->Password = '@28ksh@y';                           // SMTP password
        $mail->Username = MAILUSERNAME;
        $mail->Password = MAILPASSWORD;
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom(MAILUSERNAME, 'Support');
        $mail->addAddress('aakshay.satav@gmail.com', 'Joe User');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'OTP ';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>'.$otp;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'.$otp;

        $mail->send();
        return true;
        //echo 'Message has been sent';
    } catch (Exception $e) {
        //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        return false;
    }
      
    }

    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function verifyOTP($connection, $uname, $otp){
      $query="SELECT * FROM user WHERE uname = '".$uname."'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = $row['otp'];
        }
      }
      if($data[0]==$otp){
        return true;
      }else{
        return false;
      }
    }

    function updatePassword($connection, $uname, $pwd){
      $q = <<<EOD
      UPDATE user
      SET
      password=?
      WHERE
      uname=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ss", $pwd, $uname);
      $pwd = $pwd;
      $uname = $uname;
      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
    }

    function checkAppVersion(){
      $updated="outdated";
      $ch = curl_init();        
      curl_setopt($ch, CURLOPT_URL, SERVERDATAXMLLINK);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      if(curl_exec($ch) === FALSE) {
           echo "Error: " . curl_error($ch);
      } else {              
        //echo curl_exec($ch);
        $xml = simplexml_load_string(curl_exec($ch));
        $localConfig = simplexml_load_file('../config.xml');
        /*$xml->asXML('../config.xml');
        touch('../config.xml');
        chmod('../config.xml', 0777);*/
        //echo $xml->appversion;
        $updated=(intval($xml->appversion)!=intval($localConfig->appversion))?"outdated":"updated";
        //echo $updated;
      }
      return $updated;
    }

    function logout($p){
      //echo $p["sync"];
      setcookie('userId',"",time()-7*24*60*60,$_SERVER['SERVER_NAME']);
      setcookie('userid',"",time()-7*24*60*60,$_SERVER['SERVER_NAME']);
      setcookie('usermail',"",time()-7*24*60*60,'/',$_SERVER['SERVER_NAME']);
      setcookie('userrole',"",time()-7*24*60*60,'/',$_SERVER['SERVER_NAME']);
      setcookie('eurorate',"",time()-7*24*60*60,'/',$_SERVER['SERVER_NAME']);
      setcookie('rack',"",time()-7*24*60*60,'/',$_SERVER['SERVER_NAME']);
      setcookie('floor',"",time()-7*24*60*60,'/',$_SERVER['SERVER_NAME']);
      $st = $_COOKIE["status"];      
      setcookie('status',"",time()-7*24*60*60,'/',$_SERVER['SERVER_NAME']);
      if($p["sync"]=="yes"){
        if($st=="Online"){
          self::updateDB();
        } 
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>              
              window.location.href='../pages/login.php';
              </SCRIPT>");
      }       
          /*if(self::updateDB()){ 
            // if(self::updateConfig()){            
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              localStorage.clear();
              window.alert('Data Synced');
              window.location.href='../pages/login.php';
              </SCRIPT>");
            // }       
          }
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Error Syncing Data!!');
            window.location.href='../pages/login.php';
            </SCRIPT>");
        }
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Error Syncing Data!!');
              window.location.href='../pages/login.php';
              </SCRIPT>");
      }*/
    }

    function updateConfig(){
      $ch = curl_init();        
      curl_setopt($ch, CURLOPT_URL, SERVERDATAXMLLINK);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      if(curl_exec($ch) === FALSE) {
        echo "Error: " . curl_error($ch);
      } else {                      
        $xml = simplexml_load_string(curl_exec($ch));
        $xml->asXML('../config.xml');
        touch('../config.xml');
        chmod('../config.xml', 0777);
        return true;
      }
    }

    function updateDB(){          
      $success = false;
      $curl = curl_init();
      $uploadRequest = array('dbversion' => 0,'updateVersion' => 'updateVersion');
      curl_setopt($curl, CURLOPT_URL, SERVERDATADB);      
      curl_setopt($curl, CURLOPT_TIMEOUT, 3);
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $uploadRequest);
      $response = curl_exec($curl);
      curl_close($curl);      
      $ch = curl_init();        
      curl_setopt($ch, CURLOPT_URL, "http://www.igmrobotics.com/pushClient/igm.txt");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      if(curl_exec($ch) === FALSE) {
           echo "Error: " . curl_error($ch);
      } else {              
           //echo curl_exec($ch);
      }

      curl_close($ch); 
      //echo $response;            
      if($response == "Exported"){        
        $success = false;
        $curl = curl_init();        
        //curl_setopt($curl, CURLOPT_URL, "http://www.metroservisol.com/igm/igm.sql");
        curl_setopt($curl, CURLOPT_URL, "http://www.igmrobotics.com/pushClient/igm.txt");
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $sql = array();
        $response = curl_exec($curl);
        //echo $response;
        if(curl_exec($curl) === FALSE) {
             echo "Error: " . curl_error($curl);
        } else {                           
            $response = curl_exec($curl);
            $sql = explode(';',$response);
            //var_dump($sql);
            @$link = mysql_connect("localhost".':'."3306", "root", "root");
            @$link1 = mysql_connect("localhost".':'."3306", "root", "");
            if($link){
                //$connection = mysqli_connect('localhost','root','root','igm');
                $connection = mysqli_connect('localhost','root','root');
            }else{
                //$connection = mysqli_connect('localhost','root','','igm');
                $connection = mysqli_connect('localhost','root','');
            }     
            $result = $connection->query("DROP DATABASE IF EXISTS igm;");         
            $result = $connection->query("CREATE DATABASE igm;");
            $result = $connection->query("USE igm;");
            $connection->query("CREATE USER 'metroadmin'@'localhost' IDENTIFIED BY 'metroadmin';");
            $connection->query("GRANT ALL PRIVILEGES ON igm . * TO 'metroadmin'@'localhost';");
            $connection->query("FLUSH PRIVILEGES;");          
            foreach($sql as $query){
              //echo $query;        
              $result = mysqli_query($connection,$query.";");
              if($result){
                $success = true;        
              }else{
                $success = false;
              }
            }                 
        }
        if($success){
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            localStorage.clear();
            window.alert('Data Synced!!');
            window.location.href='../pages/login.php';
            </SCRIPT>");
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
            localStorage.clear();
            window.alert('Data Synced!!!');
            window.location.href='../pages/login.php';
            </SCRIPT>");
        }
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              localStorage.clear();
              window.alert('Error Syncing!!!');
              window.location.href='../pages/login.php';
              </SCRIPT>");
      }        
    }
  }

 ?>
