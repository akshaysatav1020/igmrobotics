<?php
/**
 * Purchase Order details
 */
 require("poPartsObject.php");

class PurchaseOrder{
  private $id = 0;
  private $purchaseOrderNo = null;
  private $to = null;
  private $po_date = null;
  private $po_validity = null;
  private $quotationId = null;
  private $projectNo = null;
  private $quotationDate = null;
  private $currency = null;
  private $eurorate = null;
  private $package = null;
  private $discount = null;
  private $igst = null;
  private $poParts = array();
  private $payment_terms = null;
  private $delivery_terms = null;
  private $terms = null;
  private $cb = null;
  private $co = null;
  private $mb = null;
  private $mo = null;
  function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
      case 21:
        self::__construct1($args[0],$args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8],
         $args[9], $args[10],  $args[11],  $args[12],  $args[13],  $args[14],  $args[15],  $args[16],  $args[17], 
         $args[18], $args[19],  $args[19],  $args[20]);
        break;
      case 20:
        self::__construct2($args[0],$args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8],
         $args[9], $args[10],  $args[11],  $args[12],  $args[13],  $args[14],  $args[15],  $args[16],  $args[17],
         $args[18], $args[19]);
        break;
        case 18:
          self::__construct3($args[0],$args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8],
        $args[9],  $args[10],  $args[11],  $args[12],  $args[13],  $args[14],  $args[15], $args[16],  $args[17]);
          break;
    }
  }
  //19
  public function __construct1($id, $purchaseOrderNo, $projectNo, $to,$po_date, $po_validity, $payment_terms,$delivery_terms, $terms, $quotationId, $quotationDate,$currency, $eurorate, $package,$discount, $igst,
   ArrayObject $poParts, $cb, $co, $mb, $mo){
    $this->id = $id;
    $this->purchaseOrderNo = $purchaseOrderNo;
    $this->projectNo = $projectNo;
    $this->to = $to;
    $this->po_date = $po_date;
    $this->po_validity = $po_validity;
    $this->payment_terms = $payment_terms;
    $this->delivery_terms = $delivery_terms;
    $this->terms = $terms;
    $this->quotationId = $quotationId;
    $this->quotationDate = $quotationDate;
    $this->currency = $currency;
    $this->eurorate = $eurorate;
    $this->package = $package;
    $this->discount=$discount;
    $this->igst=$igst;
    $this->poParts = $poParts;
    $this->cb = $cb;
    $this->co = $co;
    $this->mb = $mb;
    $this->mo = $mo;
  }

  //18
  public function __construct2($purchaseOrderNo, $projectNo, $to,$po_date, $po_validity, $payment_terms,$delivery_terms, $terms, $quotationId, $quotationDate,$currency, $eurorate, $package,$discount, $igst,
   ArrayObject $poParts, $cb, $co, $mb, $mo){
    $this->purchaseOrderNo = $purchaseOrderNo;
    $this->projectNo = $projectNo;
    $this->to = $to;
    $this->po_date = $po_date;
    $this->po_validity = $po_validity;
    $this->payment_terms = $payment_terms;
    $this->delivery_terms = $delivery_terms;
    $this->terms = $terms;
    $this->quotationId = $quotationId;
    $this->quotationDate = $quotationDate;
    $this->currency = $currency;
    $this->eurorate = $eurorate;
    $this->package = $package;
    $this->discount=$discount;
    $this->igst=$igst;
    $this->poParts = $poParts;
    $this->cb = $cb;
    $this->co = $co;
    $this->mb = $mb;
    $this->mo = $mo;
  }

  //16
  public function __construct3($id, $purchaseOrderNo, $projectNo, $to,$po_date, $po_validity, $payment_terms,$delivery_terms, $terms, $quotationId, $quotationDate,$currency,$eurorate, $package,$discount, $igst, $mb, $mo){
    $this->id = $id;
    $this->purchaseOrderNo = $purchaseOrderNo;
    $this->projectNo = $projectNo;
    $this->to = $to;
    $this->po_date = $po_date;
    $this->po_validity = $po_validity;
    $this->payment_terms = $payment_terms;
    $this->delivery_terms = $delivery_terms;
    $this->terms = $terms;
    $this->quotationId = $quotationId;
    $this->quotationDate = $quotationDate;
    $this->currency = $currency;
    $this->eurorate = $eurorate;
    $this->package = $package;
    $this->discount=$discount;
    $this->igst=$igst;
    $this->mb = $mb;
    $this->mo = $mo;
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
    public function getPurchaseOrderNo()
    {
        return $this->purchaseOrderNo;
    }

    /**
     * @param mixed $purchaseOrderNo
     *
     * @return self
     */
    public function setPurchaseOrderNo($purchaseOrderNo)
    {
        $this->purchaseOrderNo = $purchaseOrderNo;

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
    public function getPoDate()
    {
        return $this->po_date;
    }

    /**
     * @param mixed $po_date
     *
     * @return self
     */
    public function setPoDate($po_date)
    {
        $this->po_date = $po_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoValidity()
    {
        return $this->po_validity;
    }

    /**
     * @param mixed $po_validity
     *
     * @return self
     */
    public function setPoValidity($po_validity)
    {
        $this->po_validity = $po_validity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuotationId()
    {
        return $this->quotationId;
    }

    /**
     * @param mixed $quotationId
     *
     * @return self
     */
    public function setQuotationId($quotationId)
    {
        $this->quotationId = $quotationId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProjectNo()
    {
        return $this->projectNo;
    }

    /**
     * @param mixed $projectNo
     *
     * @return self
     */
    public function setProjectNo($projectNo)
    {
        $this->projectNo = $projectNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuotationDate()
    {
        return $this->quotationDate;
    }

    /**
     * @param mixed $quotationDate
     *
     * @return self
     */
    public function setQuotationDate($quotationDate)
    {
        $this->quotationDate = $quotationDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEurorate()
    {
        return $this->eurorate;
    }

    /**
     * @param mixed $eurorate
     *
     * @return self
     */
    public function setEurorate($eurorate)
    {
        $this->eurorate = $eurorate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     *
     * @return self
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoParts()
    {
        return $this->poParts;
    }

    /**
     * @param mixed $poParts
     *
     * @return self
     */
    public function setPoParts($poParts)
    {
        $this->poParts = $poParts;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentTerms()
    {
        return $this->payment_terms;
    }

    /**
     * @param mixed $payment_terms
     *
     * @return self
     */
    public function setPaymentTerms($payment_terms)
    {
        $this->payment_terms = $payment_terms;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliveryTerms()
    {
        return $this->delivery_terms;
    }

    /**
     * @param mixed $delivery_terms
     *
     * @return self
     */
    public function setDeliveryTerms($delivery_terms)
    {
        $this->delivery_terms = $delivery_terms;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param mixed $terms
     *
     * @return self
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

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
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     *
     * @return self
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIgst()
    {
        return $this->igst;
    }

    /**
     * @param mixed $igst
     *
     * @return self
     */
    public function setIgst($igst)
    {
        $this->igst = $igst;

        return $this;
    }
}
?>
