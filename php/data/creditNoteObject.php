<?php
/**
 * Credit Note details
 * getId getCnno getTo getRefno getCnparts getCb getCo
 * CreditNote($id,$cnno,$to,$refno,ArrayObject $cnparts,$cb,$co,$mb,$mo)
 */
class CreditNote{
  private $id = 0;  
  private $cnno = null;
  private $projectNo = null;
  private $to = null;
  private $refno = null;
  private $courier = null;
  private $dispatchno = null;
  private $cgst = null;  
  private $sgst = null;
  private $igst = null;
  private $cnparts = array();
  private $cb = null;
  private $co = null;
  private $mb = null;
  private $mo = null;
  function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
        case 15:
        self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],
        $args[9],$args[10],$args[11],$args[12],$args[13],$args[14]);
        break;
      case 14:
        self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],
        $args[9],$args[10],$args[11],$args[12],$args[13]);
        break;
      case 11:
        self::__construct3($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],
        $args[9],$args[10]);
        break;
    }
  }

  function __construct1($id,$cnno,$projectNo,$to,$refno, $courier,$dispatchno, $cgst, $sgst, $igst,ArrayObject $cnparts,$cb,$co,$mb,$mo){
    $this->id = $id;
    $this->cnno = $cnno;
    $this->to = $to;
    $this->refno = $refno;
    $this->cnparts = $dnparts;
    $this->cb = $cb;
    $this->co = $co;
    $this->mb = $mb;
    $this->mo = $mo;
    $this->projectNo = $projectNo;  
    $this->courier = $courier;  
    $this->dispatchno = $dispatchno;
    $this->cgst = $cgst;
    $this->sgst = $sgst;
    $this->igst = $igst;
  }

  function __construct2($cnno,$projectNo,$to,$refno, $courier,$dispatchno, $cgst, $sgst, $igst,ArrayObject $cnparts,$cb,$co,$mb,$mo){
    $this->cnno = $cnno;
    $this->to = $to;
    $this->refno = $refno;
    $this->cnparts = $cnparts;
    $this->cb = $cb;
    $this->co = $co;
    $this->mb = $mb;
    $this->mo = $mo;
    $this->projectNo = $projectNo;  
    $this->courier = $courier;  
    $this->dispatchno = $dispatchno;
    $this->cgst = $cgst;
    $this->sgst = $sgst;
    $this->igst = $igst;
  }

  function __construct3($id,$projectNo,$to,$refno, $courier,$dispatchno, $cgst, $sgst, $igst,$mb,$mo){
    $this->id = $id;    
    $this->to = $to;
    $this->refno = $refno;
    $this->mb = $mb;
    $this->mo = $mo;
    $this->projectNo = $projectNo;  
    $this->courier = $courier;  
    $this->dispatchno = $dispatchno;
    $this->cgst = $cgst;
    $this->sgst = $sgst;
    $this->igst = $igst;
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
    public function getCnno()
    {
        return $this->cnno;
    }

    /**
     * @param mixed $cnno
     *
     * @return self
     */
    public function setCnno($cnno)
    {
        $this->cnno = $cnno;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     *
     * @return self
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefno()
    {
        return $this->refno;
    }

    /**
     * @param mixed $refno
     *
     * @return self
     */
    public function setRefno($refno)
    {
        $this->refno = $refno;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCnparts()
    {
        return $this->cnparts;
    }

    /**
     * @param mixed $cnparts
     *
     * @return self
     */
    public function setCnparts($cnparts)
    {
        $this->cnparts = $cnparts;

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
   * Get the value of projectNo
   */ 
  public function getProjectNo()
  {
    return $this->projectNo;
  }

  /**
   * Set the value of projectNo
   *
   * @return  self
   */ 
  public function setProjectNo($projectNo)
  {
    $this->projectNo = $projectNo;

    return $this;
  }

  /**
   * Get the value of courier
   */ 
  public function getCourier()
  {
    return $this->courier;
  }

  /**
   * Set the value of courier
   *
   * @return  self
   */ 
  public function setCourier($courier)
  {
    $this->courier = $courier;

    return $this;
  }

  /**
   * Get the value of dispatchno
   */ 
  public function getDispatchno()
  {
    return $this->dispatchno;
  }

  /**
   * Set the value of dispatchno
   *
   * @return  self
   */ 
  public function setDispatchno($dispatchno)
  {
    $this->dispatchno = $dispatchno;

    return $this;
  }

  /**
   * Get the value of cgst
   */ 
  public function getCgst()
  {
    return $this->cgst;
  }

  /**
   * Set the value of cgst
   *
   * @return  self
   */ 
  public function setCgst($cgst)
  {
    $this->cgst = $cgst;

    return $this;
  }

  /**
   * Get the value of sgst
   */ 
  public function getSgst()
  {
    return $this->sgst;
  }

  /**
   * Set the value of sgst
   *
   * @return  self
   */ 
  public function setSgst($sgst)
  {
    $this->sgst = $sgst;

    return $this;
  }

  /**
   * Get the value of igst
   */ 
  public function getIgst()
  {
    return $this->igst;
  }

  /**
   * Set the value of igst
   *
   * @return  self
   */ 
  public function setIgst($igst)
  {
    $this->igst = $igst;

    return $this;
  }
}

?>
