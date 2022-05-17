<?php

/**
 *User Details
 */
class User
{
  private $id = 0;
  private $name = null;
  private $address = null;
  private $email = null;
  private $contact1 = null;
  private $contact2 = null;
  private $uname = null;
  private $password = null;
  private $otp = null;
  private $role = null;
  private $active = null;
  private $approved = null;
  private $cb = null;
  private $co = null;
  private $mb = null;
  private $mo = null;
  function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
      case 14:
        self::__construct1($args[0], $args[1],$args[2], $args[3],$args[4], $args[5],$args[6], $args[7],$args[8], $args[9],$args[10],
         $args[11],$args[12], $args[13]);
        break;
      case 15:
        self::__construct2($args[0], $args[1],$args[2], $args[3],$args[4], $args[5],$args[6], $args[7],$args[8], $args[9],$args[10],
          $args[11],$args[12], $args[13], $args[14]);
        break;
      case 11:
        self::__construct4($args[0], $args[1],$args[2], $args[3],$args[4], $args[5],$args[6], $args[7],$args[8], $args[9],$args[10]);
        break;
      case 3:
      self::__construct3($args[0], $args[1],$args[2]);
      break;
    }
  }
  function __construct1($name, $address, $email, $contact1, $contact2, $uname, $password, $role, $active, $approved, $cb, $co, $mb, $mo){
    $this->name = $name;
    $this->address = $address;
    $this->email = $email;
    $this->contact1 = $contact1;
    $this->contact2 = $contact2;
    $this->uname = $uname;
    $this->password = $password;
    $this->role = $role;
    $this->active = $active;
    $this->approved = $approved;
    $this->cb = $cb;
    $this->co = $co;
    $this->mb = $mb;
    $this->mo = $mo;
  }

  function __construct2($id, $name, $address, $email, $contact1, $contact2, $uname, $password, $role, $active, $approved, $cb, $co, $mb, $mo){
    $this->id = $id;
    $this->name = $name;
    $this->address = $address;
    $this->email = $email;
    $this->contact1 = $contact1;
    $this->contact2 = $contact2;
    $this->uname = $uname;
    $this->password = $password;
    $this->role = $role;
    $this->active = $active;
    $this->approved = $approved;
    $this->cb = $cb;
    $this->co = $co;
    $this->mb = $mb;
    $this->mo = $mo;
  }

  function __construct4($id, $name, $address, $email, $contact1, $contact2, $uname, $password, $role,  $mb, $mo){
    $this->id = $id;
    $this->name = $name;
    $this->address = $address;
    $this->email = $email;
    $this->contact1 = $contact1;
    $this->contact2 = $contact2;
    $this->uname = $uname;
    $this->password = $password;
    $this->role = $role;
    $this->mb = $mb;
    $this->mo = $mo;
  }

  function __construct3($id, $uname, $otp){
    $this->id = $id;
    $this->uname = $uname;
    $this->otp = $otp;
  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
      $this->id = $id;
      return $this;
  }

  public function getName(){
      return $this->name;
  }

  public function setName($name){
      $this->name = $name;
      return $this;
  }

  public function getOtp(){
      return $this->otp;
  }

  public function setOtp($otp){
      $this->otp = $otp;
      return $this;
  }

  public function getAddress(){
      return $this->address;
  }
  public function setAddress($address){
      $this->address = $address;
      return $this;
  }

  public function getEmail(){
      return $this->email;
  }

  public function setEmail($email){
      $this->email = $email;
      return $this;
  }

  public function getContact1(){
      return $this->contact1;
  }

  public function setContact1($contact1){
      $this->contact1 = $contact1;
      return $this;
  }

  public function getContact2(){
      return $this->contact2;
  }

  public function setContact2($contact2){
      $this->contact2 = $contact2;
      return $this;
  }

  public function getUname(){
      return $this->uname;
  }

  public function setUname($uname){
      $this->uname = $uname;
      return $this;
  }

  public function getPassword(){
      return $this->password;
  }

  public function setPassword($password){
      $this->password = $password;
      return $this;
  }

  public function getRole(){
      return $this->role;
  }

  public function setRole($role){
      $this->role = $role;
      return $this;
  }

  public function getActive(){
      return $this->active;
  }

  public function setActive($active){
      $this->active = $active;
      return $this;
  }

  public function getApproved(){
      return $this->approved;
  }

  public function setApproved($approved){
      $this->approved = $approved;
      return $this;
  }

  public function getCb(){
      return $this->cb;
  }

  public function setCb($cb){
      $this->cb = $cb;
      return $this;
  }

  public function getCo(){
      return $this->co;
  }

  public function setCo($co){
      $this->co = $co;
      return $this;
  }

  public function getMb(){
      return $this->mb;
  }

  public function setMb($mb){
      $this->mb = $mb;
      return $this;
  }

  public function getMo(){
      return $this->mo;
  }

  public function setMo($mo){
      $this->mo = $mo;
      return $this;
  }
}
 ?>
