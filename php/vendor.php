<?php
  require_once "db.php";
  require "data/vendorObject.php";
  require_once "updateDBVersion.php";
  require_once "updateServerDBVersion.php";
  /**
   * Vendor operations
   */
   // company_name company_address contact_person1_name contact_person1_number contact_person1_email
   // contact_person2_name contact_person2_number contact_person2_email created_by created_on
   // modified_by modified_on
  class VendorClass{
    function addVendor($connection, Vendor $vendor){
      $q = <<<EOD
      INSERT INTO vendors
      (vno,company_name, addressline1, addressline2, city, country, contact_person1_name, contact_person1_number,
      contact_person1_email, contact_person2_name, contact_person2_number, contact_person2_email,
      created_by, created_on, modified_by, modified_on)
      VALUES
      (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssssssssssssssss", $vno, $company, $addressline1,$addressline2,$city,$country, $person1, $contact1, $email1, $person2,  $contact2, $email2, $cb, $co, $mb, $mo);
      $vno = $vendor->getVno();
      $company = $vendor->getCompany();
      $addressline1 = $vendor->getAddressline1();
      $addressline2 = $vendor->getAddressline2();
      $city = $vendor->getCity();
      $country = $vendor->getCountry();
      $person1 = $vendor->getContactPerson1();
      $contact1 = $vendor->getContactPrimary();
      $email1 = $vendor->getEmailPrimary();
      $person2 = $vendor->getContactPerson2();
      $contact2 = $vendor->getContactSecondary();
      $email2 = $vendor->getEmailSecondary();
      $cb = $vendor->getCb();
      $co = $vendor->getCo();
      $mb = $vendor->getMb();
      $mo = $vendor->getMo();
      if($stmt->execute()){
        return true;
        // $upSDB = new UpdateServerDBVersion();
          /*if($upSDB->updateDBVersion()){
          }else{
            return false;
          }*/
      }else{
        return false;
      }
    }


    function getAllVendors($connection){
      $query="SELECT * FROM vendors limit 50";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'vno'=>$row['vno'],'company'=>$row['company_name'],
          'addressline1'=>$row['addressline1'],'addressline2'=>$row['addressline2'],
          'city'=>$row['city'],'country'=>$row['country'],
          'person1'=>$row['contact_person1_name'],'no1'=>$row['contact_person1_number'],
          'email1'=>$row['contact_person1_email'],'person2'=>$row['contact_person2_name'],
          'no2'=>$row['contact_person2_number'], 'email2'=>$row['contact_person2_email'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
        }
      }
      echo json_encode($data);
    }
    function getVendor($connection,$id){
      $query="SELECT * FROM vendors WHERE id = ".$id."";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'vno'=>$row['vno'],'company'=>$row['company_name'],
          'addressline1'=>$row['addressline1'],'addressline2'=>$row['addressline2'],
          'city'=>$row['city'],'country'=>$row['country'],
          'person1'=>$row['contact_person1_name'],'no1'=>$row['contact_person1_number'],
          'email1'=>$row['contact_person1_email'],'person2'=>$row['contact_person2_name'],
          'no2'=>$row['contact_person2_number'], 'email2'=>$row['contact_person2_email'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
        }
      }
      echo json_encode($data);
    }
    function editVendor($connection,Vendor $vendor){

      //getId getCompany getCompanyAddress getContactPerson1 getContactPerson2
      // getContactPrimary getContactSecondary getEmailPrimary getEmailSecondary getCo
      $q = <<<EOD
      UPDATE vendors
      SET
      vno=?,company_name=?,addressline1=?, addressline2=?, city=?, country=?,contact_person1_name=?,
      contact_person1_number=?,contact_person1_email=?,contact_person2_name=?,
      contact_person2_number=?,contact_person2_email=?,
      modified_by=?,modified_on=?
      WHERE
      id=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssssssssssssssi", $vno,$company, $addressline1,$addressline2,$city,$country, $person1, $contact1, $email1, $person2,  $contact2, $email2, $mb, $mo,$id);
      $vno = $vendor->getVno();
      $company = $vendor->getCompany();
      $addressline1 = $vendor->getAddressline1();
      $addressline2 = $vendor->getAddressline2();
      $city = $vendor->getCity();
      $country = $vendor->getCountry();
      $person1 = $vendor->getContactPerson1();
      $contact1 = $vendor->getContactPrimary();
      $email1 = $vendor->getEmailPrimary();
      $person2 = $vendor->getContactPerson2();
      $contact2 = $vendor->getContactSecondary();
      $email2 = $vendor->getEmailSecondary();
      $mb = $vendor->getMb();
      $mo = $vendor->getMo();
      $id = $vendor->getId();
      if($stmt->execute()){
        return true;
        //$upSDB = new UpdateServerDBVersion();
          /*if($upSDB->updateDBVersion()){
          }else{
            return false;
          }*/
      }else{
        return false;
      }
    }
    function deleteVendor($connection,$vendorId){
      $q = <<<EOD
      DELETE FROM vendors
      WHERE
      id=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("i", $id);
      $id = $vendorId;
      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
    }

    function getVendorNo($connection){
      $query="SELECT vno FROM vendors ORDER BY id desc LIMIT 1";
      $result = $connection->query($query);
      $vno = "NA";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $vno = $row['vno'];
        }
      }
      echo $vno+1;
    }
    
    function getVendorsForSelect($connection,$params){
      $query="SELECT id,company_name, city  FROM vendors WHERE company_name LIKE '%".$params["term"]["term"]."%'";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){                    
          $data[] = array('id'=>$row['id'],'company'=>$row['company_name']."-".$row['city']);
        }
      }      
      echo json_encode($data);
    }
  }

  if($_POST!=null){
    $db = new DB();
    $d = new DateTime();
    $vendor = new VendorClass();
    $cb = $mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
    if(isset($_POST['addVendor'])){

		$secper = ($_POST["contactper2"]!="")?$_POST["contactper2"]:"Not Specified";
      $seccon = ($_POST["contactsec"]!="")?$_POST["contactsec"]:"Not Specified";
      $secemail = ($_POST["emailsec"]!="")?$_POST["emailsec"]:"Not Specified";
      $vendorObject = new Vendor($_POST["vno"],$_POST["companyname"], 
      $_POST["addressline1"], $_POST["addressline2"],$_POST["city"],$_POST["country"],
      $_POST["contactper1"],
       $secper, $_POST["contactpri"], $seccon, $_POST["emailpri"],
        $secemail, $cb, $d->format('Y-m-d H:i:s'), $mb, $d->format('Y-m-d H:i:s'));
      if($vendor->addVendor($db->getConnection(), $vendorObject)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Added')
              window.location.href='../pages/vendor.php';
              </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Error Adding')
              window.location.href='../pages/vendor.php';
              </SCRIPT>");
      }
    }else if(isset($_POST["editVendor"])){
	  $secper = ($_POST["econtactper2"]!="")?$_POST["econtactper2"]:"Not Specified";
      $seccon = ($_POST["econtactsec"]!="")?$_POST["econtactsec"]:"Not Specified";
      $secemail = ($_POST["eemailsec"]!="")?$_POST["eemailsec"]:"Not Specified";
      $vendorObject = new Vendor($_POST['vendorId'], $_POST["evno"],$_POST["ecompanyname"], 
      $_POST["eaddressline1"], $_POST["eaddressline2"],$_POST["ecity"],$_POST["ecountry"],
      $_POST["econtactper1"], $secper, $_POST["econtactpri"], $seccon, $_POST["eemailpri"], $secemail, $cb, $d->format('Y-m-d H:i:s'), $cb, $d->format('Y-m-d H:i:s'));
      //var_dump($vendorObject);
      if($vendor->editVendor($db->getConnection(), $vendorObject)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Edited')
              window.location.href='../pages/vendor.php';
              </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Error Editing')
              window.location.href='../pages/vendor.php';
              </SCRIPT>");
      }
    }else if(isset($_POST["viewAll"])){
      $vendor->getAllVendors($db->getConnection());
    }else if(isset($_POST["viewVendor"])){
      $vendor->getVendor($db->getConnection(),$_POST["vendorId"]);
    }else if(isset($_POST["deleteVendor"])){
      if($vendor->deleteVendor($db->getConnection(),$_POST["vendorId"])){
        echo "Deleted";
      }else{
        echo "Error Adding";
      }
    }else if(isset($_POST["getVendorNo"])){
      $vendor->getVendorNo($db->getConnection());     
    }else if(isset($_POST["getVendorsForSelect"])){
      $vendor->getVendorsForSelect($db->getConnection(), $_POST);
    }
  }else{
    //echo "Unauthorised access!";
  }

?>
