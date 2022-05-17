<?php
  /**
   * Inventory In warehouse details
   *getId getSerialNo getLocation getTimestamp getUsed getPartNo getInvoiceNo getCb getCo 
  */
  class InventoryWarehouse{
    private $id = 0;
    private $serialNo = null;
    private $partNo = null;
    private $timestamp = null;
    private $used = null;
    private $po = null;
    private $inwardno = null;
    private $invoiceNo = null;
    private $chno = null;
    private $chdate = null;
    private $importDate = null;
    private $clearingCharges = null;
    private $billEntryNo = null;
    private $returnable = null;
    private $cb = null;
    private $co = null;
    private $mb = null;
    private $mo = null;
    function __construct(){
      $args = func_get_args();
      switch(func_num_args()){
        case 18:
          self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],
            $args[9],$args[10],$args[11], $args[12], $args[13],$args[14], $args[15], $args[16], $args[17]);
          break;
        case 10:
          self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],
            $args[8],$args[9]);
          break;
        case 12:
        self::__construct3($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10],$args[11]);
        break;
      }
    }

    function __construct1($id, $serialNo, $po, $timestamp, $used, $partNo, $invoiceNo,$chno, $chdate, $importDate, $clearingCharges, $billEntryNo, $returnable, $cb, $co, $mb, $mo){
      $this->id = $id;
      $this->po = $po;
      $this->inwardno =$inwardno;
      $this->timestamp = $timestamp;
      $this->used = $used;
      $this->partNo = $partNo;
      $this->invoiceNo = $invoiceNo;
      $this->chno = $chno;
      $this->chdate = $chdate;
      $this->importDate=$importDate;
      $this->clearingCharges=$clearingCharges;
      $this->billEntryNo=$billEntryNo;
      $this->returnable = $returnable;
      $this->cb = $cb;
      $this->co = $co;
      $this->mb = $mb;
      $this->mo = $mo;
    }

    function __construct2($serialNo, $po, $timestamp,  $partNo, $chno, $chdate, $importDate, $clearingCharges, $billEntryNo){
      $this->serialNo = $serialNo;
      $this->po = $po;
      $this->inwardno =$inwardno;
      $this->timestamp = $timestamp;      
      $this->partNo = $partNo;
      $this->chno = $chno;
      $this->chdate = $chdate;
      $this->importDate=$importDate;
      $this->clearingCharges=$clearingCharges;
      $this->billEntryNo=$billEntryNo;
    }

    function __construct3($id, $serialNo, $po, $used, $partNo,$chno, $chdate, $importDate,
        $clearingCharges, $billEntryNo, $returnable){
      $this->id = $id;
      $this->serialNo = $serialNo;
      $this->po = $po;
      $this->inwardno =$inwardno;
      $this->used = $used;
      $this->partNo = $partNo;      
      $this->chno = $chno;
      $this->chdate = $chdate;
      $this->importDate=$importDate;
      $this->clearingCharges=$clearingCharges;
      $this->billEntryNo=$billEntryNo;
      $this->returnable = $returnable;
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
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * @param mixed $serialNo
     *
     * @return self
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPartNo()
    {
        return $this->partNo;
    }

    /**
     * @param mixed $partNo
     *
     * @return self
     */
    public function setPartNo($partNo)
    {
        $this->partNo = $partNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     *
     * @return self
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @param mixed $used
     *
     * @return self
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPo()
    {
        return $this->po;
    }

    /**
     * @param mixed $po
     *
     * @return self
     */
    public function setPo($po)
    {
        $this->po = $po;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNo()
    {
        return $this->invoiceNo;
    }

    /**
     * @param mixed $invoiceNo
     *
     * @return self
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChno()
    {
        return $this->chno;
    }

    /**
     * @param mixed $chno
     *
     * @return self
     */
    public function setChno($chno)
    {
        $this->chno = $chno;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChdate()
    {
        return $this->chdate;
    }

    /**
     * @param mixed $chdate
     *
     * @return self
     */
    public function setChdate($chdate)
    {
        $this->chdate = $chdate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImportDate()
    {
        return $this->importDate;
    }

    /**
     * @param mixed $importDate
     *
     * @return self
     */
    public function setImportDate($importDate)
    {
        $this->importDate = $importDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClearingCharges()
    {
        return $this->clearingCharges;
    }

    /**
     * @param mixed $clearingCharges
     *
     * @return self
     */
    public function setClearingCharges($clearingCharges)
    {
        $this->clearingCharges = $clearingCharges;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillEntryNo()
    {
        return $this->billEntryNo;
    }

    /**
     * @param mixed $billEntryNo
     *
     * @return self
     */
    public function setBillEntryNo($billEntryNo)
    {
        $this->billEntryNo = $billEntryNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnable()
    {
        return $this->returnable;
    }

    /**
     * @param mixed $returnable
     *
     * @return self
     */
    public function setReturnable($returnable)
    {
        $this->returnable = $returnable;

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
     * @return mixed
     */
    public function getInwardno()
    {
        return $this->inwardno;
    }

    /**
     * @param mixed $inwardno
     *
     * @return self
     */
    public function setInwardno($inwardno)
    {
        $this->inwardno = $inwardno;

        return $this;
    }
}

?>
