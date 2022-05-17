<?php
/**
 * Invoice details
 *  `id`, `inv_no`, `cust_id`, `date`, `shipment_date`,
 * `transport`, `vehicle`, `freight`, `terms`, `created_by`, `created_on`, `modified_by`, `modified_on`
* getId getInvoiceNo getTo getDate getShipmentDate getTransport getVehicle getFreight getTerms getCb getCo getMb getMo getInvParts
 */
 require("invParts.php");
class Invoice{
  private $id = 0;
  private $invoiceNo = null;
  private $projectNo = null;
  private $to = 0;
  private $date = null;
  private $shipment_date = null;
  private $transport = null;
  private $vehicle = null;
  private $invParts = array();
  private $freight = null;
  private $courier = null;
  private $dispatchno = null;
  private $terms = null;
  private $cancelled = null;
  
  private $refno = null;
  private $refdate = null;
  private $igst = null;
  private $cgst = null;
  private $sgst = null;
  private $packaging = null;
  private $total = null;

  private $cb = null;
  private $co = null;
  private $mb = null;
  private $mo = null;
  function __construct(){
    $args = func_get_args();
    //echo func_num_args();
    switch(func_num_args()){
      case 25:
        self::__construct1($args[0],$args[1], $args[2],$args[3],$args[4], $args[5],$args[6],$args[7], $args[8],
                            $args[9],$args[10], $args[11],$args[12],$args[13],$args[14],
                            $args[15], $args[16],$args[17],$args[18], $args[19],$args[20],
                            $args[21],$args[22],$args[23],$args[24]);
        break;
      case 24:
        self::__construct2($args[0],$args[1], $args[2],$args[3],$args[4], $args[5],$args[6],$args[7], $args[8],
                            $args[9],$args[10], $args[11],$args[12],$args[13],$args[14],
                            $args[15], $args[16],$args[17],$args[18], $args[19],$args[20],
                            $args[21],$args[22],$args[23]);
        break;
        case 21:
          self::__construct3($args[0],$args[1], $args[2],$args[3],$args[4], $args[5],$args[6],$args[7], $args[8],
                              $args[9],$args[10], $args[11],$args[12],$args[13],$args[14],
                              $args[15], $args[16],$args[17],$args[18], $args[19],$args[20]);
        case 2:
          self::__construct4($args[0],$args[1]);
    }
  }

  function __construct1($id,$invoiceNo,$projectNo,$to,$date,$shipment_date,$transport,$vehicle,$freight,
  $courier, $dispatchno, $terms,$cancelled,$cb,$co,$mb,$mo,
  $refno, $refdate, $igst, $cgst, $sgst, $packaging, $total, ArrayObject $invParts){
      $this->id = $id;
      $this->invoiceNo = $invoiceNo;
      $this->to = $to;
      $this->date = $date;
      $this->shipment_date = $shipment_date;
      $this->transport = $transport;
      $this->vehicle = $vehicle;
      $this->freight = $freight;
      $this->terms = $terms;
      $this->cancelled = $cancelled;
      $this->cb = $cb;
      $this->co = $co;
      $this->mb = $mb;
      $this->mo = $mo;

      $this->refno = $refno;
      $this->refdate = $refdate;
      $this->igst = $igst;
      $this->cgst = $cgst;
      $this->sgst = $sgst;
      $this->packaging = $packaging;
      $this->total = $total;

      $this->invParts = $invParts;
      $this->projectNo = $projectNo;  
      $this->courier = $courier;  
      $this->dispatchno = $dispatchno;    
  }

  function __construct2($invoiceNo,$projectNo,$to,$date,$shipment_date,$transport,$vehicle,$freight,
  $courier, $dispatchno,$terms,$cancelled,$cb,$co,$mb,$mo,
   $refno, $refdate, $igst, $cgst, $sgst, $packaging, $total,
   ArrayObject $invParts){
      $this->invoiceNo = $invoiceNo;
      $this->to = $to;
      $this->date = $date;
      $this->shipment_date = $shipment_date;
      $this->transport = $transport;
      $this->vehicle = $vehicle;
      $this->freight = $freight;
      $this->terms = $terms;
      $this->cancelled = $cancelled;
      $this->cb = $cb;
      $this->co = $co;
      $this->mb = $mb;
      $this->mo = $mo;
      $this->refno = $refno;
      $this->refdate = $refdate;
      $this->igst = $igst;
      $this->cgst = $cgst;
      $this->sgst = $sgst;
      $this->packaging = $packaging;
      $this->total = $total;
      $this->invParts = $invParts;
      $this->projectNo = $projectNo;  
      $this->courier = $courier;  
      $this->dispatchno = $dispatchno;
  }

  function __construct3($id,$invoiceNo,$projectNo,$to,$date,$shipment_date,$transport,$vehicle,$freight,
  $courier, $dispatchno,$terms,$mb,$mo,
  $refno, $refdate, $igst, $cgst, $sgst, $packaging, $total){
      $this->id = $id;
      $this->invoiceNo = $invoiceNo;
      $this->to = $to;
      $this->date = $date;
      $this->shipment_date = $shipment_date;
      $this->transport = $transport;
      $this->vehicle = $vehicle;
      $this->freight = $freight;
      $this->terms = $terms;
      // $this->cancelled = $cancelled;
      $this->mb = $mb;
      $this->mo = $mo;
      $this->refno = $refno;
      $this->refdate = $refdate;
      $this->igst = $igst;
      $this->cgst = $cgst;
      $this->sgst = $sgst;
      $this->packaging = $packaging;
      $this->total = $total;
      $this->projectNo = $projectNo;  
      $this->courier = $courier;  
      $this->dispatchno = $dispatchno;
  }

  function __construct4($id,$cancelled){
      $this->id = $id;
      $this->cancelled = $cancelled;
  }

    public function getId(){
        return $this->id;
    }


    public function setId($id){
        $this->id = $id;
        return $this;
    }


    public function getInvoiceNo(){
        return $this->invoiceNo;
    }


    public function setInvoiceNo($invoiceNo){
        $this->invoiceNo = $invoiceNo;
        return $this;
    }


    public function getTo(){
        return $this->to;
    }


    public function setTo($to){
        $this->to = $to;
        return $this;
    }


    public function getDate(){
        return $this->date;
    }


    public function setDate($date){
        $this->date = $date;
        return $this;
    }


    public function getShipmentDate(){
        return $this->shipment_date;
    }


    public function setShipmentDate($shipment_date){
        $this->shipment_date = $shipment_date;
        return $this;
    }


    public function getTransport(){
        return $this->transport;
    }


    public function setTransport($transport){
        $this->transport = $transport;
        return $this;
    }


    public function getVehicle(){
        return $this->vehicle;
    }


    public function setVehicle($vehicle){
        $this->vehicle = $vehicle;
        return $this;
    }


    public function getFreight(){
        return $this->freight;
    }

    public function setFreight($freight){
        $this->freight = $freight;
        return $this;
    }


    public function getTerms(){
        return $this->terms;
    }


    public function setTerms($terms){
        $this->terms = $terms;
        return $this;
    }

    public function getCancelled(){
        return $this->cancelled;
    }


    public function setCancelled($cancelled){
        $this->cancelled = $cancelled;
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

    public function getInvParts()
    {
        return $this->invParts;
    }

    public function setInvParts($invParts)
    {
        $this->invParts = $invParts;

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
   * Get the value of refno
   */ 
  public function getRefno()
  {
    return $this->refno;
  }

  /**
   * Set the value of refno
   *
   * @return  self
   */ 
  public function setRefno($refno)
  {
    $this->refno = $refno;

    return $this;
  }

  

  /**
   * Get the value of total
   */ 
  public function getTotal()
  {
    return $this->total;
  }

  /**
   * Set the value of total
   *
   * @return  self
   */ 
  public function setTotal($total)
  {
    $this->total = $total;

    return $this;
  }

  /**
   * Get the value of packaging
   */ 
  public function getPackaging()
  {
    return $this->packaging;
  }

  /**
   * Set the value of packaging
   *
   * @return  self
   */ 
  public function setPackaging($packaging)
  {
    $this->packaging = $packaging;

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

  /**
   * Get the value of refdate
   */ 
  public function getRefdate()
  {
    return $this->refdate;
  }

  /**
   * Set the value of refdate
   *
   * @return  self
   */ 
  public function setRefdate($refdate)
  {
    $this->refdate = $refdate;

    return $this;
  }
}
?>
