<?php
class CustomerObject{
  private $id = null;
  private $cno = null;
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
  private $discount1 = null;
  private $discount2 = null;
  private $discount3 = null;
  private $cb = null;
  private $co = null;
  private $mb = null;
  private $mo = null;

  function __construct(){
    $argv = func_get_args();
        switch( func_num_args() ) {
            case 19:
                self::__construct1($argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8], $argv[9],
                 $argv[10], $argv[11], $argv[12], $argv[13], $argv[14], $argv[15], $argv[16], $argv[17], $argv[18]);
                break;
            case 20:
                self::__construct2($argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8], $argv[9],
                 $argv[10], $argv[11], $argv[12], $argv[13], $argv[14], $argv[15], $argv[16], $argv[17], $argv[18], $argv[19]);
                break;
         }
  }

  function __construct1($cno,$company, $addressline1,$addressline2,$city,
  $country, $contactPerson1, $contactPerson2, $contactPrimary,
   $contactSecondary, $emailPrimary, $emailSecondary, $discount1, $discount2, $discount3, $cb, $co, $mb, $mo){
    $this->cno = $cno; 
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
     $this->discount1 = $discount1;
     $this->discount2 = $discount2;
     $this->discount3 = $discount3;
     $this->cb=$cb;
     $this->co=$co;
     $this->mb=$mb;
     $this->mo=$mo;
   }

  function __construct2($id, $cno, $company, $addressline1,$addressline2,$city,
  $country, $contactPerson1, $contactPerson2, $contactPrimary,
   $contactSecondary, $emailPrimary, $emailSecondary, $discount1, $discount2, $discount3, $cb, $co, $mb, $mo){
     $this->id = $id;
     $this->cno = $cno;
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
     $this->discount1 = $discount1;
     $this->discount2 = $discount2;
     $this->discount3 = $discount3;
     $this->cb=$cb;
     $this->co=$co;
     $this->mb=$mb;
     $this->mo=$mo;
  }

  


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     *
     * @return self
     */
    public function setCompany($company)
    {
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

    /**
     * @return mixed
     */
    public function getContactPerson1()
    {
        return $this->contactPerson1;
    }

    /**
     * @param mixed $contactPerson1
     *
     * @return self
     */
    public function setContactPerson1($contactPerson1)
    {
        $this->contactPerson1 = $contactPerson1;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactPerson2()
    {
        return $this->contactPerson2;
    }

    /**
     * @param mixed $contactPerson2
     *
     * @return self
     */
    public function setContactPerson2($contactPerson2)
    {
        $this->contactPerson2 = $contactPerson2;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactPrimary()
    {
        return $this->contactPrimary;
    }

    /**
     * @param mixed $contactPrimary
     *
     * @return self
     */
    public function setContactPrimary($contactPrimary)
    {
        $this->contactPrimary = $contactPrimary;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactSecondary()
    {
        return $this->contactSecondary;
    }

    /**
     * @param mixed $contactSecondary
     *
     * @return self
     */
    public function setContactSecondary($contactSecondary)
    {
        $this->contactSecondary = $contactSecondary;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailPrimary()
    {
        return $this->emailPrimary;
    }

    /**
     * @param mixed $emailPrimary
     *
     * @return self
     */
    public function setEmailPrimary($emailPrimary)
    {
        $this->emailPrimary = $emailPrimary;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailSecondary()
    {
        return $this->emailSecondary;
    }

    /**
     * @param mixed $emailSecondary
     *
     * @return self
     */
    public function setEmailSecondary($emailSecondary)
    {
        $this->emailSecondary = $emailSecondary;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount1()
    {
        return $this->discount1;
    }

    /**
     * @param mixed $discount1
     *
     * @return self
     */
    public function setDiscount1($discount1)
    {
        $this->discount1 = $discount1;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount2()
    {
        return $this->discount2;
    }

    /**
     * @param mixed $discount2
     *
     * @return self
     */
    public function setDiscount2($discount2)
    {
        $this->discount2 = $discount2;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount3()
    {
        return $this->discount3;
    }

    /**
     * @param mixed $discount3
     *
     * @return self
     */
    public function setDiscount3($discount3)
    {
        $this->discount3 = $discount3;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCb()
    {
        return $this->cb;
    }

    /**
     * @param mixed $cb
     *
     * @return self
     */
    public function setCb($cb)
    {
        $this->cb = $cb;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCo()
    {
        return $this->co;
    }

    /**
     * @param mixed $co
     *
     * @return self
     */
    public function setCo($co)
    {
        $this->co = $co;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMb()
    {
        return $this->mb;
    }

    /**
     * @param mixed $mb
     *
     * @return self
     */
    public function setMb($mb)
    {
        $this->mb = $mb;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMo()
    {
        return $this->mo;
    }

    /**
     * @param mixed $mo
     *
     * @return self
     */
    public function setMo($mo)
    {
        $this->mo = $mo;

        return $this;
    }

  /**
   * Get the value of cno
   */ 
  public function getCno()
  {
    return $this->cno;
  }

  /**
   * Set the value of cno
   *
   * @return  self
   */ 
  public function setCno($cno)
  {
    $this->cno = $cno;

    return $this;
  }
}
?>
