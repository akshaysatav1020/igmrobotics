<?php
class Vendor{
  private $id = 0;
  private $vno = 0;
  private $company = null;
  private $addressline1 = null;
  private $addressline2 = null;
  private $city = null;
  private $country = null;
  private $contactPerson1 = null;
  private $contactPerson2 = null;
  private $contactPrimary = null;
  private $contactSecondary = null;
  private $emailPrimary = null;
  private $emailSecondary = null;
  private $cb = null;
  private $co = null;
  private $mb = null;
  private $mo = null;

  function __construct(){
    $argv = func_get_args();
        switch( func_num_args() ) {
            case 16:
                self::__construct1($argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8], $argv[9],
                 $argv[10], $argv[11],$argv[12], $argv[13],$argv[14], $argv[15]);
                break;
            case 17:
                self::__construct2($argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8], $argv[9],
                $argv[10], $argv[11],$argv[12], $argv[13],$argv[14], $argv[15], $argv[16]);
                break;
         }
  }

  function __construct1($vno, $company, $addressline1,$addressline2,$city,
  $country, $contactPerson1, $contactPerson2, $contactPrimary,$contactSecondary, $emailPrimary,
   $emailSecondary, $cb, $co, $mb, $mo){
    $this->vno = $vno;
     $this->company = $company;
     $this->addressline1 = $addressline1;
     $this->addressline2 = $addressline2;
     $this->city = $city;
     $this->country = $country;
     $this->contactPerson1 = $contactPerson1;
     $this->contactPerson2 = $contactPerson2;
     $this->contactPrimary = $contactPrimary;
     $this->contactSecondary = $contactSecondary;
     $this->emailPrimary = $emailPrimary;
     $this->emailSecondary = $emailSecondary;
     $this->cb=$cb;
     $this->co=$co;
     $this->mb=$mb;
     $this->mo=$mo;
   }

  function __construct2($id, $vno, $company, $addressline1,$addressline2,$city,
  $country, $contactPerson1, $contactPerson2, $contactPrimary,
   $contactSecondary, $emailPrimary, $emailSecondary, $cb, $co, $mb, $mo){
     $this->id = $id;
     $this->vno = $vno;
     $this->company = $company;
     $this->addressline1 = $addressline1;
     $this->addressline2 = $addressline2;
     $this->city = $city;
     $this->country = $country;
     $this->contactPerson1 = $contactPerson1;
     $this->contactPerson2 = $contactPerson2;
     $this->contactPrimary = $contactPrimary;
     $this->contactSecondary = $contactSecondary;
     $this->emailPrimary = $emailPrimary;
     $this->emailSecondary = $emailSecondary;
     $this->cb=$cb;
     $this->co=$co;
     $this->mb=$mb;
     $this->mo=$mo;
  }

  public function getId(){
      return $this->id;
  }

  public function setId($id){
      $this->id = $id;
      return $this;
  }

  public function getCompany(){
      return $this->company;
  }

  public function setCompany($company){
      $this->company = $company;
      return $this;
  }

  public function getAddressline1()
  {
    return $this->addressline1;
  }

  
  public function setAddressline1($addressline1)
  {
    $this->addressline1 = $addressline1;

    return $this;
  }

  public function getAddressline2()
  {
    return $this->addressline2;
  }

  
  public function setAddressline2($addressline2)
  {
    $this->addressline2 = $addressline2;

    return $this;
  }

  public function getCity()
  {
    return $this->city;
  }

 
  public function setCity($city)
  {
    $this->city = $city;

    return $this;
  }

  public function getCountry()
  {
    return $this->country;
  }

  
  public function setCountry($country)
  {
    $this->country = $country;

    return $this;
  }
  

  public function getContactPerson1()
  {
      return $this->contactPerson1;
  }

  public function setContactPerson1($contactPerson1)
  {
      $this->contactPerson1 = $contactPerson1;

      return $this;
  }


  public function getContactPerson2()
  {
      return $this->contactPerson2;
  }


  public function setContactPerson2($contactPerson2)
  {
      $this->contactPerson2 = $contactPerson2;

      return $this;
  }

  public function getContactPrimary()
  {
      return $this->contactPrimary;
  }


  public function setContactPrimary($contactPrimary)
  {
      $this->contactPrimary = $contactPrimary;

      return $this;
  }


  public function getContactSecondary()
  {
      return $this->contactSecondary;
  }


  public function setContactSecondary($contactSecondary)
  {
      $this->contactSecondary = $contactSecondary;

      return $this;
  }

  public function getEmailPrimary()
  {
      return $this->emailPrimary;
  }


  public function setEmailPrimary($emailPrimary)
  {
      $this->emailPrimary = $emailPrimary;

      return $this;
  }


  public function getEmailSecondary()
  {
      return $this->emailSecondary;
  }


  public function setEmailSecondary($emailSecondary)
  {
      $this->emailSecondary = $emailSecondary;

      return $this;
  }

    public function getCb()
    {
        return $this->cb;
    }

    public function setCb($cb)
    {
        $this->cb = $cb;

        return $this;
    }

    public function getCo()
    {
        return $this->co;
    }
    public function setCo($co)
    {
        $this->co = $co;

        return $this;
    }
    public function getMb()
    {
        return $this->mb;
    }
    public function setMb($mb)
    {
        $this->mb = $mb;

        return $this;
    }
    public function getMo()
    {
        return $this->mo;
    }

    public function setMo($mo)
    {
        $this->mo = $mo;

        return $this;
    }

  

  /**
   * Get the value of vno
   */ 
  public function getVno()
  {
    return $this->vno;
  }

  /**
   * Set the value of vno
   *
   * @return  self
   */ 
  public function setVno($vno)
  {
    $this->vno = $vno;

    return $this;
  }
}

?>
