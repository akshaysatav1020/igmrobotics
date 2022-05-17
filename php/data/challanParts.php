<?php
/**
 * `id`, `dcId`, `partId`, `qty`, `unitprice`, `partTotAmount`
 *  getId getDcId getPartId getQty getUnitprice getPartTotAmount
 */
class ChallanParts{
  private $id=0;
  private $dcId=0;
  private $inwardNo= 0;
  private $partId=0;
  private $serials = array();
  private $qty=0;
  private $unitprice=0;
  private $landedcost= 0;
  private $sellingprice= 0;
  private $part_dis = 0;
  private $partTotAmount=0;

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

    function __construct1($id,  $dcId,$inwardNo,$partId,$qty,$unitprice,$landedcost, $sellingprice, $part_dis,$partTotAmount,$serials){
        $this->id = $id;
        $this->dcId = $dcId;
        $this->inwardNo = $inwardNo;
        $this->sellingprice = $sellingprice;
        $this->landedcost=$landedcost;
        $this->partId = $partId;
        $this->qty = $qty;
        $this->unitprice = $unitprice;
        $this->part_dis = $part_dis;
        $this->partTotAmount = $partTotAmount;
        $this->serials = $serials;
    }

    function __construct2($dcId,$inwardNo, $partId,$qty,$unitprice,$landedcost, $sellingprice,$part_dis,$partTotAmount,$serials){
        $this->dcId = $dcId;
        $this->partId = $partId;
        $this->inwardNo = $inwardNo;
        $this->sellingprice = $sellingprice;
        $this->landedcost=$landedcost;
        $this->qty = $qty;
        $this->unitprice = $unitprice;
        $this->part_dis = $part_dis;
        $this->partTotAmount = $partTotAmount;
        $this->serials =  $serials;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getDcId(){
        return $this->dcId;
    }

    public function setDcId($dcId){
        $this->dcId = $dcId;
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

    public function getPartDis()
    {
        return $this->part_dis;
    }

    /**
     * @param mixed $part_dis
     *
     * @return self
     */
    public function setPartDis($part_dis)
    {
        $this->part_dis = $part_dis;

        return $this;
    }

    public function getPartTotAmount(){
        return $this->partTotAmount;
    }

    public function setPartTotAmount($partTotAmount){
        $this->partTotAmount = $partTotAmount;
        return $this;
    }

    public function getSerials(){
        return $this->serials;
    }

    public function setSerials($serials){
        $this->serials =  $serials;
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
