<?php
  /**
   * Delivery Challan details
   * getId getDeliveryChallanNo getDate getRefno getRefDate getReturnable getTransport getVehicleNo getFreight getShipDate
   * getTo getLrno getTerms getCb getCo getMb getMo getChallanParts
   */
   require("challanParts.php");
  class DeliveryChallan{
    private $id=0;
    private $deliveryChallanNo = null;
    private $invoice = null;
    private $projectNo = null;
    private $to=0;
    private $isDate = null;
    private $refno = null;
    private $refDate = null;
    private $returnable = null;
    private $transport = null;
    private $challanParts = array();
    private $lrno = null;
    private $vehicleNo = null;
    private $courier = null;
    private $dispatchno = null;
    private $freight = null;
    private $shipDate = null;
    private $terms = null;
    private $closing_status=null;
    private $cb = null;
    private $co = null;
    private $mb = null;
    private $mo = null;
    function __construct(){
      $args = func_get_args();
      switch(func_num_args()){
        case 23:
          self::__construct1($args[0], $args[1],$args[2], $args[3],$args[4], $args[5],$args[6], $args[7],
            $args[8], $args[9],$args[10], $args[11],$args[12], $args[13],$args[14], $args[15],$args[16],
            $args[17], $args[18],$args[19],$args[20],$args[21],$args[22]);
          break;
        case 21:
          self::__construct2($args[0], $args[1],$args[2], $args[3],$args[4], $args[5],$args[6], $args[7],
            $args[8], $args[9],$args[10], $args[11],$args[12], $args[13],$args[14], $args[15],$args[16],
             $args[17],$args[18],$args[19],$args[20]);
          break;
        case 19:
          self::__construct3($args[0], $args[1],$args[2], $args[3],$args[4], $args[5],$args[6], $args[7],
            $args[8], $args[9],$args[10], $args[11],$args[12], $args[13],$args[14], $args[15],$args[16],
            $args[17],$args[18]);
          break;
      }
    }
    function __construct1($id,$to,$deliveryChallanNo,$invoice,$projectNo,$isDate,$refno,$refDate,$returnable,$transport,$lrno,
    $vehicleNo,$courier, $dispatchno,$freight,$shipDate,
    $terms,$closingStatus,$cb,$co,$mb,$mo, ArrayObject $challanParts){
      $this->id = $id;
      $this->to = $to;
      $this->deliveryChallanNo = $deliveryChallanNo;
      $this->invoice=$invoice;
      $this->date = $isDate;
      $this->refno = $refno;
      $this->isDate = $isDate;
      $this->refDate = $refDate;
      $this->returnable = $returnable;
      $this->transport = $transport;
      $this->lrno = $lrno;
      $this->vehicleNo = $vehicleNo;
      $this->freight = $freight;
      $this->shipDate = $shipDate;
      $this->terms = $terms;
      $this->closingStatus=$closingStatus;
      $this->cb = $cb;
      $this->co = $co;
      $this->mb = $mb;
      $this->mo = $mo;
      $this->challanParts = $challanParts;
      $this->projectNo = $projectNo;  
      $this->courier = $courier;  
      $this->dispatchno = $dispatchno;
    }
    function __construct2($to,$deliveryChallanNo,$invoice,$projectNo,$isDate,$refno,$refDate,$returnable,$transport,$lrno,
    $vehicleNo, $courier, $dispatchno,$freight,$shipDate,$terms,$cb,$co,$mb,$mo, ArrayObject $challanParts){
      $this->to = $to;
      $this->deliveryChallanNo = $deliveryChallanNo;
      $this->invoice=$invoice;
      $this->date = $isDate;
      $this->refno = $refno;
      $this->isDate = $isDate;
      $this->refDate = $refDate;
      $this->returnable = $returnable;
      $this->transport = $transport;
      $this->lrno = $lrno;
      $this->vehicleNo = $vehicleNo;
      $this->freight = $freight;
      $this->shipDate = $shipDate;
      $this->terms = $terms;
      $this->closingStatus=0;
      $this->cb = $cb;
      $this->co = $co;
      $this->mb = $mb;
      $this->mo = $mo;
      $this->challanParts = $challanParts;
      $this->projectNo = $projectNo;  
      $this->courier = $courier;  
      $this->dispatchno = $dispatchno;
    }

    function __construct3($id,$to,$deliveryChallanNo,$invoice,$projectNo,$isDate,$refno,$refDate,$returnable,$transport,$lrno,
    $vehicleNo,$courier, $dispatchno,$freight,$shipDate,$terms,$mb,$mo){
      $this->id = $id;
      $this->to = $to;
      $this->deliveryChallanNo = $deliveryChallanNo;
      $this->invoice=$invoice;
      $this->date = $isDate;
      $this->refno = $refno;
      $this->isDate = $isDate;
      $this->refDate = $refDate;
      $this->returnable = $returnable;
      $this->transport = $transport;
      $this->lrno = $lrno;
      $this->vehicleNo = $vehicleNo;
      $this->freight = $freight;
      $this->shipDate = $shipDate;
      $this->terms = $terms;
      $this->mb = $mb;
      $this->mo = $mo;
      $this->projectNo = $projectNo;  
      $this->courier = $courier;  
      $this->dispatchno = $dispatchno;
    }


    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getDeliveryChallanNo(){
        return $this->deliveryChallanNo;
    }

    public function setDeliveryChallanNo($deliveryChallanNo){
        $this->deliveryChallanNo = $deliveryChallanNo;
        return $this;
    }

    public function getRefno(){
        return $this->refno;
    }

    public function setRefno($refno){
        $this->refDate = $refno;
        return $this;
    }

    public function getRefDate(){
        return $this->refDate;
    }

    public function setRefDate($refDate){
        $this->refDate = $refDate;
        return $this;
    }

    public function getReturnable(){
        return $this->returnable;
    }

    public function setReturnable($returnable){
        $this->returnable = $returnable;
        return $this;
    }

    public function getTransport(){
        return $this->transport;
    }

    public function setTransport($transport){
        $this->transport = $transport;
        return $this;
    }

    public function getVehicleNo(){
        return $this->vehicleNo;
    }

    public function setVehicleNo($vehicleNo){
        $this->vehicleNo = $vehicleNo;
        return $this;
    }

    public function getFreight(){
        return $this->freight;
    }

    public function setFreight($freight){
        $this->freight = $freight;
        return $this;
    }

    public function getShipDate(){
        return $this->shipDate;
    }

    public function setShipDate($shipDate){
        $this->shipDate = $shipDate;
        return $this;
    }
    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    public function getIsDate()
    {
        return $this->isDate;
    }

    public function setIsDate($isDate)
    {
        $this->isDate = $isDate;

        return $this;
    }

    public function getLrno()
    {
        return $this->lrno;
    }

    public function setLrno($lrno)
    {
        $this->lrno = $lrno;

        return $this;
    }

    public function getTerms()
    {
        return $this->terms;
    }

    public function setTerms($terms)
    {
        $this->terms = $terms;

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

    public function getChallanParts()
    {
        return $this->challanParts;
    }

    public function setChallanParts($challanParts)
    {
        $this->challanParts = $challanParts;

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
     * @return mixed
     */
    public function getClosingStatus()
    {
        return $this->closing_status;
    }

    /**
     * @param mixed $closing_status
     *
     * @return self
     */
    public function setClosingStatus($closing_status)
    {
        $this->closing_status = $closing_status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param mixed $invoice
     *
     * @return self
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }
}
?>
