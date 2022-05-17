<?php
  include("db.php");
  //require_once "checkInternet.php";
  include("data/customerObject.php");
  include("updateDBVersion.php");
  include("updateServerDBVersion.php");
  class Customer{

    function __construct(){
    }
    function addCustomer($connection, CustomerObject $customer){
      $q = <<<EOD
      INSERT INTO customers
      (cno, company_name, addressline1, addressline2, city, country, contact_person1_name, contact_person1_number,
      contact_person1_email, contact_person2_name, contact_person2_number, contact_person2_email,
      discount1,discount2,discount3,
      created_by, created_on, modified_by, modified_on)
      VALUES
      (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssssssssssssdddssss", $cno, $company, $addressline1, $addressline2, $city, $country, $person1, $contact1, $email1, $person2,  $contact2, $email2,
        $discount1,$discount2,$discount3, $cb, $co, $mb, $mo);
      $cno = $customer->getCno();
      $company = $customer->getCompany();
      $addressline1 = $customer->getAddressline1();
      $addressline2 = $customer->getAddressline2();
      $city = $customer->getCity();
      $country = $customer->getCountry();
      $person1 = $customer->getContactPerson1();
      $contact1 = $customer->getContactPrimary();
      $email1 = $customer->getEmailPrimary();
      $person2 = $customer->getContactPerson2();
      $contact2 = $customer->getContactSecondary();
      $email2 = $customer->getEmailSecondary();
      $discount1 = $customer->getDiscount1();
      $discount2 = $customer->getDiscount2();
      $discount3 = $customer->getDiscount3();
      $cb = $customer->getCb();
      $co = $customer->getCo();
      $mb = $customer->getMb();
      $mo = $customer->getMo();
      if($stmt->execute()){
        return true;              
      }else{
        return false;
      }
    }

    // company_name company_address contact_person1_name contact_person1_number contact_person1_email
    // contact_person2_name contact_person2_number contact_person2_email created_by created_on
    // modified_by modified_on
    function getAllCustomers($connection){
      
      $query="SELECT * FROM customers";
      $result = $connection->query($query);
      $data = array();
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){          
          /*$data[] = array('id'=>$row['id'],'cno'=>$row['cno'],'company'=>$row['company_name'],
          'addressline1'=>$row['addressline1'],'addressline2'=>$row['addressline2'],
          'city'=>$row['city'],'country'=>$row['country'],
          'person1'=>$row['contact_person1_name'],'no1'=>$row['contact_person1_number'],
          'email1'=>$row['contact_person1_email'],'person2'=>$row['contact_person2_name'],
          'no2'=>$row['contact_person2_number'], 'email2'=>$row['contact_person2_email'],
          'discount1'=>$row['discount1'], 'discount2'=>$row['discount2'],'discount3'=>$row['discount3'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);*/
          $data[] = array('id'=>$row['id'],'cno'=>$row['cno'],'company'=>$row['company_name'],'city'=>$row['city']);
        }
      }      
      echo json_encode($data);
    }
    function getCustomer($connection,$id){
      $query="SELECT * FROM customers WHERE id = ".$id."";
			$result = $connection->query($query);
			$data = array();
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){
          $data[] = array('id'=>$row['id'],'cno'=>$row['cno'],'company'=>$row['company_name'],
          'addressline1'=>$row['addressline1'],'addressline2'=>$row['addressline2'],
          'city'=>$row['city'],'country'=>$row['country'],
          'person1'=>$row['contact_person1_name'],'no1'=>$row['contact_person1_number'],
          'email1'=>$row['contact_person1_email'],'person2'=>$row['contact_person2_name'],
          'no2'=>$row['contact_person2_number'], 'email2'=>$row['contact_person2_email'],
          'discount1'=>$row['discount1'], 'discount2'=>$row['discount2'],'discount3'=>$row['discount3'],
          'cb'=>$row['created_by'],'co'=>$row['created_on'],
          'mb'=>$row['modified_by'],'mo'=>$row['modified_on']);
				}
			}
      echo json_encode($data);
    }
    function editCustomers($connection,CustomerObject $customer){
      // var_dump($customer);
      $q = <<<EOD
      UPDATE customers
      SET
      cno=?,company_name=?,addressline1=?, addressline2=?, city=?, country=?,contact_person1_name=?,
      contact_person1_number=?,contact_person1_email=?,contact_person2_name=?,
      contact_person2_number=?,contact_person2_email=?,
      discount1 = ?, discount2 = ?, discount3 = ?,
      modified_by=?,modified_on=?
      WHERE
      id=? 
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("ssssssssssssdddssi", $cno, $company, $addressline1, $addressline2, $city, $country, $person1, $contact1, $email1, $person2,  $contact2, $email2,
       $discount1,$discount2,$discount3,$mb, $mo,$id);
      $cno = $customer->getCno();
      $company = $customer->getCompany();      
      $addressline1 = $customer->getAddressline1();
      $addressline2 = $customer->getAddressline2();
      $city = $customer->getCity();
      $country = $customer->getCountry();
      $person1 = $customer->getContactPerson1();
      $contact1 = $customer->getContactPrimary();
      $email1 = $customer->getEmailPrimary();
      $person2 = $customer->getContactPerson2();
      $contact2 = $customer->getContactSecondary();
      $email2 = $customer->getEmailSecondary();
      $discount1 = $customer->getDiscount1();
      $discount2 = $customer->getDiscount2();
      $discount3 = $customer->getDiscount3();
      $mb = $customer->getMb();
      $mo = $customer->getMo();
      $id = $customer->getId();
      if($stmt->execute()){
        return true;        
      }else{
        return false;
      }
    }
    function deleteCustomer($connection,$customerId){
      $q = <<<EOD
      DELETE FROM customers
      WHERE
      id=?
EOD;
      $stmt = $connection->prepare($q);
      $stmt->bind_param("i", $id);
      $id = $customerId;
      if($stmt->execute()){
        return true;        
      }else{
        return false;
      }
    }

    function getCustomerNo($connection){
      $query="SELECT cno FROM customers ORDER BY id desc LIMIT 1";
      $result = $connection->query($query);
      $cno = "NA";
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $cno = $row['cno'];
        }
      }
		if(intval(explode('-', $cno)[1])<99){
			echo "IGM-0".(intval(explode('-', $cno)[1])+1);
		}else{
			echo "IGM-".(intval(explode('-', $cno)[1])+1);
		}
      
    }
    
    function getCustomersForSelect($connection,$params){
      $query="SELECT id,company_name, city  FROM customers WHERE company_name LIKE '%".$params["term"]["term"]."%'";
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
    //companyname addressline1 addressline2 city country contactper1 contactper2 contactpri contactsec emailpri emailsec addCustomer
      $db = new DB();
      $customer = new Customer();
      $cb = $mb = isset($_COOKIE["usermail"])?$_COOKIE["usermail"]:"support@metroservisol.com";
    if(isset($_POST["addCustomer"])){
      $db = new DB();
      $d = new DateTime();
	     $secper = ($_POST["contactper2"]!="")?$_POST["contactper2"]:"Not Specified";
      $seccon = ($_POST["contactsec"]!="")?$_POST["contactsec"]:"Not Specified";
      $secemail = ($_POST["emailsec"]!="")?$_POST["emailsec"]:"Not Specified";
      $discount1 = ($_POST["discount1"]!="")?$_POST["discount1"]:"Not Specified";
      $discount2= ($_POST["discount2"]!="")?$_POST["discount2"]:"Not Specified";
      $discount3 = ($_POST["discount3"]!="")?$_POST["discount3"]:"Not Specified";
      $customerObject = new CustomerObject($_POST["cno"],$_POST["companyname"], $_POST["addressline1"],
        $_POST["addressline2"],$_POST["city"],$_POST["country"],
        $_POST["contactper1"], $secper, $_POST["contactpri"], $seccon, $_POST["emailpri"], $secemail,
        $discount1,$discount2,$discount3,
       $cb, $d->format('Y-m-d H:i:s'), $cb, $d->format('Y-m-d H:i:s'));
      if($customer->addCustomer($db->getConnection(), $customerObject)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Customer Added')
              window.location.href='../pages/customers.php';
              </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Error Adding')
              window.location.href='../pages/customers.php';
              </SCRIPT>");
      }
    }else if(isset($_POST["editCustomer"])){
      $d = new DateTime();
	  $secper = ($_POST["econtactper2"]!="")?$_POST["econtactper2"]:"Not Specified";
      $seccon = ($_POST["econtactsec"]!="")?$_POST["econtactsec"]:"Not Specified";
      $secemail = ($_POST["eemailsec"]!="")?$_POST["eemailsec"]:"Not Specified";
      $discount1 = ($_POST["ediscount1"]!="")?$_POST["ediscount1"]:"Not Specified";
      $discount2= ($_POST["ediscount2"]!="")?$_POST["ediscount2"]:"Not Specified";
      $discount3 = ($_POST["ediscount3"]!="")?$_POST["ediscount3"]:"Not Specified";
	  
      $customerObject = new CustomerObject($_POST["custId"], $_POST["ecno"], $_POST["ecompanyname"], 
      $_POST["eaddressline1"], $_POST["eaddressline2"],$_POST["ecity"],$_POST["ecountry"],$_POST["econtactper1"],
       $secper, $_POST["econtactpri"], $seccon, $_POST["eemailpri"], $secemail,
        $discount1,$discount2,$discount3,
       "a@gmail.com", $d->format('Y-m-d H:i:s'), $cb, $d->format('Y-m-d H:i:s'));
      // var_dump($customerObject);
      if($customer->editCustomers($db->getConnection(), $customerObject)){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Customer edited')
              window.location.href='../pages/customers.php';
              </SCRIPT>");
      }else{
        echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Error Editing')
              window.location.href='../pages/customers.php';
              </SCRIPT>");
      }
    }else if(isset($_POST["viewAll"])){
      $customer->getAllCustomers($db->getConnection());
    }else if(isset($_POST["viewCustomer"])){
      $customer->getCustomer($db->getConnection(),$_POST["customerId"]);
    }else if(isset($_POST["deleteCustomer"])){
      if($customer->deleteCustomer($db->getConnection(),$_POST["customerId"])){
        echo "Deleted";
      }else{
        echo "Error Adding";
      }
    }else if(isset($_POST["getCustomerNo"])){
      $customer->getCustomerNo($db->getConnection());        
    }else if(isset($_POST["getCustomersForSelect"])){
      $customer->getCustomersForSelect($db->getConnection(), $_POST);
    }
  }else{
    $customer = new Customer();        
    $c = new mysqli(HOST, USER, PASSWORD, DB);
    $customer->getAllCustomers($c);
    
}

?>
