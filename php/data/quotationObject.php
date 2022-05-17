<?php
/**
 * Purchase Order details
 *  getId getQuotationNo getTo getTin getServicetax getPan getDated getValidityDate getTerms getSgst getCgst
 *   getTotalAmount getQoParts getCb getCo getMb getMo
 */
 require "quoParts.php";
 // require "inventoryPartObject.php";
class Quotation{
  private $id = 0;
  private $quotationNo = null;
  private $projectNo = null;
  private $to = 0;
  private $refno = null;
  private $refdate = null;
  private $qoParts = array();
  private $dated = null;
  private $validityDate = null;
  private $terms = null;
  private $sgst = null;
  private $cgst = null;
  private $igst = null;
  private $packaging = null;
  private $totalAmount = null;
  private $cb = null;
  private $co = null;
  private $mb = null;
  private $mo = null;

  function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
      case 19:
        self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],
        $args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16],$args[17],$args[18]);
        break;
      case 18:
        self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],
        $args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16],$args[17]);
        break;
      case 16:
        self::__construct3($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],
        $args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15]);
        break;
    }
  }

  public function __construct1($id,$quotationNo,$projectNo,$to,$refno, $refdate, $qoParts,$dated,$validityDate,
                                $terms,$sgst,$cgst,$igst,$packaging,$totalAmount,$cb,$co,$mb,$mo){
  $this->id = $id;
  $this->quotationNo = $quotationNo;
  $this->projectNo = $projectNo;
  $this->to = $to;
  $this->refno = $refno;
  $this->refdate = $refdate;
  $this->qoParts = $qoParts;
  $this->dated = $dated;
  $this->validityDate = $validityDate;
  $this->terms = $terms;
  $this->sgst = $sgst;
  $this->cgst = $cgst;
  $this->igst = $igst;  
  $this->packaging = $packaging;     
  $this->totalAmount = $totalAmount;
  $this->cb = $cb;
  $this->co = $co;
  $this->mb = $mb;
  $this->mo = $mo;
  }

  public function __construct2($quotationNo,$projectNo,$to,$refno, $refdate, $qoParts,$dated,$validityDate,
                                $terms,$sgst,$cgst,$igst,$packaging,$totalAmount,$cb,$co,$mb,$mo){
    $this->quotationNo = $quotationNo;
    $this->projectNo = $projectNo;
    $this->to = $to;
    $this->refno = $refno;
    $this->refdate = $refdate;
    $this->qoParts = $qoParts;
    $this->dated = $dated;
    $this->validityDate = $validityDate;
    $this->terms = $terms;
    $this->sgst = $sgst;
    $this->cgst = $cgst;
    $this->igst = $igst;    
    $this->packaging = $packaging;   
    $this->totalAmount = $totalAmount;
    $this->cb = $cb;
    $this->co = $co;
    $this->mb = $mb;
    $this->mo = $mo;
  }

  public function __construct3($id,$quotationNo,$projectNo,$to, $refno, $refdate,$dated,$validityDate,
                                $terms,$sgst,$cgst,$igst,$packaging,$totalAmount,$mb,$mo){
    $this->id = $id;
    $this->quotationNo = $quotationNo;
    $this->projectNo = $projectNo;
    $this->to = $to;
    $this->refno = $refno;
    $this->refdate = $refdate;
    $this->dated = $dated;
    $this->validityDate = $validityDate;
    $this->terms = $terms;
    $this->sgst = $sgst;
    $this->cgst = $cgst;
    $this->igst = $igst; 
    $this->packaging = $packaging;   
    $this->totalAmount = $totalAmount;
    $this->mb = $mb;
    $this->mo = $mo;
  }

  public function getId(){
      return $this->id;
  }

  public function setId($id){
      $this->id = $id;
      return $this;
  }

  public function getQuotationNo(){
      return $this->quotationNo;
  }

  public function setQuotationNo($quotationNo){
      $this->quotationNo = $quotationNo;
      return $this;
  }

  public function getTo(){
      return $this->to;
  }

  public function setTo($to){
      $this->to = $to;
      return $this;
  }

  // public function getTin(){
  //     return $this->tin;
  // }
  //
  // public function setTin($tin){
  //     $this->tin = $tin;
  //     return $this;
  // }
  //
  // public function getServicetax(){
  //     return $this->servicetax;
  // }
  //
  // public function setServicetax($servicetax){
  //     $this->servicetax = $servicetax;
  //     return $this;
  // }
  //
  // public function getPan(){
  //     return $this->pan;
  // }
  //
  // public function setPan($pan){
  //     $this->pan = $pan;
  //     return $this;
  // }

  public function getPoParts(){
      return $this->poParts;
  }

  public function setPoParts($poParts){
      $this->poParts = $poParts;
      return $this;
  }

  public function getDated(){
      return $this->dated;
  }

  public function setDated($dated){
      $this->dated = $dated;
      return $this;
  }

  public function getValidityDate(){
      return $this->validityDate;
  }

  public function setValidityDate($validityDate){
      $this->validityDate = $validityDate;
      return $this;
  }

  public function getTerms(){
      return $this->terms;
  }

  public function setTerms($terms){
      $this->terms = $terms;
      return $this;
  }

  public function getSgst(){
      return $this->sgst;
  }

  public function setSgst($sgst){
      $this->sgst = $sgst;
      return $this;
  }

  public function getCgst(){
      return $this->cgst;
  }

  public function setCgst($cgst){
      $this->cgst = $cgst;
      return $this;
  }

  public function getTotalAmount(){
      return $this->totalAmount;
  }

  public function setTotalAmount($totalAmount){
      $this->totalAmount = $totalAmount;
      return $this;
  }

    public function getQoParts(){
        return $this->qoParts;
    }

    public function setQoParts($qoParts){
        $this->qoParts = $qoParts;
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
