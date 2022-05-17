<?php
  require_once "db.php";
  require_once "data/userObject.php";
  require_once "updateServerDBVersion.php";

// name address email contact1 contact2 uname password
// role active approved created_by created_on
// modified_by modified_on
  class Register{
    function addUser($connection, User $customer){
      $q = <<<EOD
      INSERT INTO user
      (name, address, email, contact1, contact2, uname, password, otp, role, active,
      approved, created_by, created_on, modified_by, modified_on)
      VALUES
      (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, ?,(SELECT NOW()),?,(SELECT NOW()))
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("sssssssssss", $name, $address, $email, $contact1, $contact2, 
        $uname, $password, $otp, $role, $cb, $mb);
      $name = $customer->getName();
      $address = $customer->getAddress();
      $email = $customer->getEmail();
      $contact1 = $customer->getContact1();
      $contact2 = $customer->getContact2();
      $uname = $customer->getUname();
      $password = $customer->getPassword();
      $otp = "";
      $role = $customer->getRole();
      $cb = $_COOKIE["usermail"];
      $mb = $_COOKIE["usermail"];
      if($stmt->execute()){
        return true;       
      }else{
        echo $stmt->error;
        return false;
      }
    }

    function getAllUsers($connection){
      $query="SELECT * FROM user limit 50";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = array('id'=>$row['id'],'name'=>$row['name'],'address'=>$row['address'],
          'email'=>$row['email'],'contact1'=>$row['contact1'],
          'contact2'=>$row['contact2'],'uname'=>$row['uname'],
          'password'=>$row['password'], 'role'=>$row['role'],
          'active'=>$row['active'],'approved'=>$row['approved'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
      echo json_encode($data);
    }

    function activateUser($connection, $id, $status){
      $q = <<<EOD
        UPDATE user
        SET
        active=?
        WHERE
        id=?
EOD;
        $stmt = $connection->prepare($q);
        $stmt->bind_param("ii", $status,$id);
        $status = $status;
        $id = $id;
        if($stmt->execute()){
          return true;
          
        }else{
          return false;
        }
    }

    function approveUser($connection, $id, $status){
      $q = <<<EOD
        UPDATE user
        SET
        approved=?
        WHERE
        id=?
EOD;
        $stmt = $connection->prepare($q);
        $stmt->bind_param("ii", $status,$id);
        $status = $status;
        $id = $id;
        if($stmt->execute()){
          return true;
          /*$upSDB = new UpdateServerDBVersion();
          if($upSDB->updateDBVersion()){
          }else{
            return false;
          }*/
        }else{
          return false;
        }
    }

    function getUser($connection,$id){
      $query="SELECT * FROM user WHERE id = ".$id."";
			$result = $connection->query($query);
			$data = "";
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
          $data = array('id'=>$row['id'],'name'=>$row['name'],'address'=>$row['address'],
          'email'=>$row['email'],'contact1'=>$row['contact1'],
          'contact2'=>$row['contact2'],'uname'=>$row['uname'],
          'password'=>$row['password'], 'role'=>$row['role'],
          'active'=>$row['active'],'approved'=>$row['approved'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
      echo json_encode($data);
    }
    function editUser($connection,User $user){
      // if(self::checkUsername($user->getUname())){
        $q = <<<EOD
        UPDATE user
        SET
        name=?,address=?,email=?,
        contact1=?,contact2=?,password=?,role=?,
        modified_by=?,modified_on=?
        WHERE
        id=?
EOD;
        $stmt = $connection->prepare($q);
        $stmt->bind_param("sssssssssi", $name,$address,$email, $contact1,$contact2,$password,$role, $mb,$mo,$id);
        $name = $user->getName();
        $address = $user->getAddress();
        $email = $user->getEmail();
        $contact1 = $user->getContact1();
        $contact2 = $user->getContact2();
        $password = $user->getPassword();
        $role = $user->getRole();
        $mb = $user->getMb();
        $mo = $user->getMo();
        $id = $user->getId();
        if($stmt->execute()){
          return true;
          /*$upSDB = new UpdateServerDBVersion();
          if($upSDB->updateDBVersion()){
          }else{
            return false;
          }*/
        }else{
          return false;
        }
      // }else{
      //   return false;
      // }
    }
    function deleteUser($connection,$id){
      $q = <<<EOD
      DELETE FROM user
      WHERE
      id=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("i", $id);
      $id = $id;
      if($stmt->execute()){
        return true;
        /*$upSDB = new UpdateServerDBVersion();
        if($upSDB->updateDBVersion()){
        }else{
          return false;
        }*/
      }else{
        return false;
      }
    }

    function checkUsername($connection,$userName){
      $query="SELECT * FROM user WHERE uname = '".$userName."'";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row['id'];
				}
			}
      // echo sizeof($data);
      if(sizeof($data)>0){
        echo "Exist";
      }else{
        echo "NotExist";
      }
    }

    function checkEmail($connection, $email){
      $query="SELECT * FROM user WHERE email = '".$email."'";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
					$data[] = $row['id'];
				}
			}
      // echo sizeof($data);
      if(sizeof($data)>0){
        echo "Exist";
      }else{
        echo "NotExist";
      }
    }
  }

  if($_POST!=null){
    //name address contactpri contactpsec email username password role
    $db = new DB();
    $register = new Register();
    $date= new DateTime();
    $connection = $db->getConnection();
    $cb = $mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
      if(isset($_POST["register"])){
		  $seccon = ($_POST["contactsec"]!="")?$_POST["contactsec"]:"Not Specified";
        $user = new User($_POST["name"], $_POST["address"], $_POST["email"], $_POST["contactpri"], $seccon,
         $_POST["username"], $_POST["password"], $_POST["role"], false, false,$cb, $date->format('Y-m-d H:i:s'),
         $cb, $date->format('Y-m-d H:i:s'));
        if($register->addUser($connection, $user)){
          echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('User Added')
          window.location.href='../pages/register.php';
          </SCRIPT>");
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Error adding user')
          window.location.href='../pages/register.php';
          </SCRIPT>");
        }
      }else if(isset($_POST["editUser"])){
		  $seccon = ($_POST["econtactsec"]!="")?$_POST["econtactsec"]:"Not Specified";
        $user = new User($_POST["eid"],$_POST["ename"], $_POST["eaddress"], $_POST["eemail"], $_POST["econtactpri"],          
         $seccon, $_POST["eusername"], $_POST["epassword"], $_POST["erole"], $cb,
         $date->format('Y-m-d H:i:s'));
        //var_dump($user);
        if($register->editUser($connection,$user)){
          echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('User Updated')
          window.location.href='../pages/register.php';
          </SCRIPT>");
        }else{
          echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Error!!!')
          window.location.href='../pages/register.php';
          </SCRIPT>");
        }
      }else if(isset($_POST["viewUser"])){
        $register->getUser($connection,$_POST["userId"]);
      }else if(isset($_POST["viewAll"])){
        $register->getAllUsers($connection);
      }else if(isset($_POST["deleteUser"])){
        if($register->deleteUser($connection,$_POST["userId"])){
          echo "Deleted";
        }else{
          echo "Error Deleting";
        }
      }else if(isset($_POST["checkUsername"])){
        $register->checkUsername($connection, $_POST["username"]);
        // if($register->checkUsername($connection, $_POST["username"])){
        //   echo true;
        // }else{
        //   echo false;
        // }
      }else if(isset($_POST["checkEmail"])){
        $register->checkEmail($connection, $_POST["email"]);
      }else if(isset($_POST['activate'])){
        if($register->activateUser($db->getConnection(), $_POST["id"], $_POST["status"])){
          echo "true";
        }else{
          echo "false";
        }
      }else if(isset($_POST['approve'])){
        if($register->approveUser($db->getConnection(), $_POST["id"], $_POST["status"])){
          echo "true";
        }else{
          echo "false";
        }
      }
  }else{
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Unauthorised Access!!')
    window.location.href='../index.html';
    </SCRIPT>");
  }
 ?>
