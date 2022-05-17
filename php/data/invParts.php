<?php
/**
 * `id`, `invId`, `partId`, `qty`, `rate`, `partTotAmount`
 *  getId getInvId getPartId getQty getRate getPartTotAmount
 */
class InvParts{
  private $id =0;
  private $invId = 0;
  private $inwardNo= 0;
  private $partId =0;
  private $qty =0;
  private $unitprice =0;
  private $landedcost= 0;
  private $sellingprice= 0;
  private $discount = 0;
  private $tax= 0;
  private $partTotAmount =0;
  function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
      case 11:
        self::__construct1($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6],$args[7], $args[8],
         $args[9],$args[10]);
        break;
      case 10:
        self::__construct2($args[0], $args[1], $args[2], $args[3], $args[4], $args[5],$args[6], $args[7], $args[8],$args[9]);
        break;
    }
  }

  function __construct1($id,$invId,$inwardNo,$partId,$qty,$unitprice,$landedcost,$sellingprice,$discount,$tax,$partTotAmount){
      $this->id = $id;
      $this->invId = $invId;
      $this->partId = $partId;
      $this->inwardNo = $inwardNo;
      $this->sellingprice = $sellingprice;
      $this->landedcost=$landedcost;
      $this->qty = $qty;
      $this->unitprice = $unitprice;
      $this->discount = $discount;
      $this->tax= $tax;
      $this->partTotAmount = $partTotAmount;
  }

  function __construct2($invId,$inwardNo,$partId,$qty,$unitprice,$landedcost,$sellingprice,$discount,$tax,$partTotAmount){
      $this->invId = $invId;
      $this->partId = $partId;
      $this->inwardNo = $inwardNo;
      $this->sellingprice = $sellingprice;
      $this->landedcost=$landedcost;
      $this->qty = $qty;
      $this->unitprice = $unitprice;
      $this->discount = $discount;
      $this->tax= $tax;
      $this->partTotAmount = $partTotAmount;
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
    public function getInvId()
    {
        return $this->invId;
    }

    /**
     * @param mixed $invId
     *
     * @return self
     */
    public function setInvId($invId)
    {
        $this->invId = $invId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPartId()
    {
        return $this->partId;
    }

    /**
     * @param mixed $partId
     *
     * @return self
     */
    public function setPartId($partId)
    {
        $this->partId = $partId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param mixed $qty
     *
     * @return self
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    

    /**
     * @return mixed
     */
    public function getPartTotAmount()
    {
        return $this->partTotAmount;
    }

    /**
     * @param mixed $partTotAmount
     *
     * @return self
     */
    public function setPartTotAmount($partTotAmount)
    {
        $this->partTotAmount = $partTotAmount;

        return $this;
    }

  /**
   * Get the value of tax
   */ 
  public function getTax()
  {
    return $this->tax;
  }

  /**
   * Set the value of tax
   *
   * @return  self
   */ 
  public function setTax($tax)
  {
    $this->tax = $tax;

    return $this;
  }

  /**
   * Get the value of discount
   */ 
  public function getDiscount()
  {
    return $this->discount;
  }

  /**
   * Set the value of discount
   *
   * @return  self
   */ 
  public function setDiscount($discount)
  {
    $this->discount = $discount;

    return $this;
  }

  /**
   * Get the value of unitprice
   */ 
  public function getUnitprice()
  {
    return $this->unitprice;
  }

  /**
   * Set the value of unitprice
   *
   * @return  self
   */ 
  public function setUnitprice($unitprice)
  {
    $this->unitprice = $unitprice;

    return $this;
  }

    /**
     * @return mixed
     */
    public function getInwardNo()
    {
        return $this->inwardNo;
    }

    /**
     * @param mixed $inwardNo
     *
     * @return self
     */
    public function setInwardNo($inwardNo)
    {
        $this->inwardNo = $inwardNo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLandedcost()
    {
        return $this->landedcost;
    }

    /**
     * @param mixed $landedcost
     *
     * @return self
     */
    public function setLandedcost($landedcost)
    {
        $this->landedcost = $landedcost;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSellingprice()
    {
        return $this->sellingprice;
    }

    /**
     * @param mixed $sellingprice
     *
     * @return self
     */
    public function setSellingprice($sellingprice)
    {
        $this->sellingprice = $sellingprice;

        return $this;
    }
}

?>
