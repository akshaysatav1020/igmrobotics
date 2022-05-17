<?php
/**
 * `id`, `quoId`, `partId`, `qty`, `unitprice`, `discount`, `tax`, `partTotAmt`
 *  getId getQuoId getPartId getQty getUnitprice getDiscount getTax getPartTotAmt
 */
class QuoParts{
    private $id= 0;
    private $quoId= 0;
    private $inwardNo= 0;
    private $partId= 0;
    private $qty= 0;
    private $unitprice= 0;
    private $landedcost= 0;
    private $sellingprice= 0;
    private $discount= 0;
    private $tax= 0;
    private $partTotAmt= 0;

  function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
      case 11:
        self::__construct1($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7],
         $args[8], $args[9], $args[10]);
        break;
      case 10:
        self::__construct2($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7],
         $args[8], $args[9]);
        break;
    }
  }

    function __construct1($id,$quoId,$inwardNo,$partId,$qty,$unitprice,$landedcost,$sellingprice,$discount,$tax,$partTotAmt){
        $this->id = $id;
        $this->quoId = $quoId;
        $this->partId = $partId;
        $this->qty = $qty;
        $this->unitprice = $unitprice;
        $this->inwardNo = $inwardNo;
        $this->sellingprice = $sellingprice;
        $this->landedcost=$landedcost;
        $this->discount = $discount;
        $this->tax = $tax;
        $this->partTotAmt = $partTotAmt;
    }

    function __construct2($quoId,$inwardNo,$partId,$qty,$unitprice,$landedcost,$sellingprice,$discount,$tax,$partTotAmt){        
        $this->quoId = $quoId;
        $this->partId = $partId;
        $this->qty = $qty;
        $this->unitprice = $unitprice;
        $this->inwardNo = $inwardNo;
        $this->sellingprice = $sellingprice;
        $this->landedcost=$landedcost;
        $this->discount = $discount;
        $this->tax = $tax;
        $this->partTotAmt = $partTotAmt;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getQuoId(){
        return $this->quoId;
    }

    public function setQuoId($quoId){
        $this->quoId = $quoId;
        return $this;
    }

    public function getPartId(){
        return $this->partId;
    }

    public function setPartId($partId){
        $this->partId = $partId;
        return $this;
    }

    public function getQty(){
        return $this->qty;
    }

    public function setQty($qty){
        $this->qty = $qty;
        return $this;
    }

    public function getUnitprice(){
        return $this->unitprice;
    }

    public function setUnitprice($unitprice){
        $this->unitprice = $unitprice;
        return $this;
    }

    public function getDiscount(){
        return $this->discount;
    }

    public function setDiscount($discount){
        $this->discount = $discount;
        return $this;
    }

    public function getTax(){
        return $this->tax;
    }

    public function setTax($tax){
        $this->tax = $tax;
        return $this;
    }

    public function getPartTotAmt(){
        return $this->partTotAmt;
    }

    public function setPartTotAmt($partTotAmt){
        $this->partTotAmt = $partTotAmt;
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
