<?php
/**
 * Inventory parts details
 */
  class InventoryPart{
    private $id = 0;
    private $partNo = null;
    private $description = null;
    private $min = null;
    private $total = 0;
    private $unitPriceEuro = null;
    private $unitPriceInr = null;
    private $landedCost = null;
    private $location = null;
    private $cb = null;
    private $co = null;
    private $mb = null;
    private $mo = null;
    private $country = null;

    function __construct(){
      $args = func_get_args();
      //echo func_num_args();
      switch(func_num_args()){
        case 12: //for adding country
          self::__construct4($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                  $args[6],$args[7],$args[8],$args[9],$args[10]);
          break;
        case 11:
          self::__construct4($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                  $args[6],$args[7],$args[8],$args[9],$args[10]);
          break;
          case 13:
          self::__construct5($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                  $args[6],$args[7],$args[8],$args[9],$args[10],$args[11]);
          break;
        case 10:
          self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                  $args[6],$args[7],$args[8],$args[9]);
          break;
        case 9:
          self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                  $args[6],$args[7],$args[8]);
          break;
        case 8:
          self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                  $args[6],$args[7]);
          break;
        case 2:
          self::__construct3($args[0],$args[1]);
          break;
      }
    }

    public function __construct1($id, $partNo, $description, $unitPriceEuro,
      $unitPriceInr,$landedCost, $location,$min, $total, $country){
      $this->id = $id;
      $this->partNo = $partNo;
      $this->description = $description;
      $this->unitPriceEuro = $unitPriceEuro;
      $this->unitPriceInr = $unitPriceInr;
      $this->landedCost = $landedCost;
      $this->location = $location;
      $this->total = $total;
      $this->min = $min;
      $this->country=$country;
    }

    public function __construct2($partNo, $description, $unitPriceEuro,
      $unitPriceInr,$landedCost, $location, $min, $total, $country){
      $this->partNo = $partNo;
      $this->description = $description;
      $this->unitPriceEuro = $unitPriceEuro;
      $this->unitPriceInr = $unitPriceInr;
      $this->landedCost = $landedCost;
      $this->location = $location;
      $this->min = $min;
      $this->total = $total;
      $this->country = $country;
    }

    public function __construct3($min, $total){
      $this->min = $min;
      $this->total = $total;      
    }

    public function __construct4($partNo, $description, $unitPrice, $location, $min, $total, $cb, $co, $mb, $mo, $country){
      $this->partNo = $partNo;
      $this->description = $description;
      $this->unitPrice = $unitPrice;
      $this->location = $location;
      $this->min = $min;
      $this->total = $total;
      $this->cb = $cb;
      $this->co = $co;
      $this->mb = $mb;
      $this->mo = $mo;
      $this->country= $country;

    }
       public function __construct5($id, $partNo, $description, $unitPrice, $location,$min, $total, $cb, $co, $mb, $mo, $country){
      $this->id = $id;
      $this->partNo = $partNo;
      $this->description = $description;
      $this->unitPrice = $unitPrice;
      $this->location = $location;
      $this->total = $total;
      $this->min = $min;
      $this->cb = $cb;
      $this->co = $co;
      $this->mb = $mb;
      $this->mo = $mo;
      $this->country= $country;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getPartNo(){
        return $this->partNo;
    }

    public function setPartNo($partNo){
        $this->partNo = $partNo;
        return $this;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    public function getUnit(){
        return $this->unit;
    }

    public function setUnit($unit){
        $this->unit = $unit;
        return $this;
    }

    public function getUnitPriceEuro(){
        return $this->unitPriceEuro;
    }

    public function setUnitPriceEuro($unitPriceEuro){
        $this->unitPriceEuro = $unitPriceEuro;
        return $this;
    }

    public function getUnitPriceInr(){
        return $this->unitPriceInr;
    }

    public function setUnitPriceInr($unitPriceInr){
        $this->unitPriceInr = $unitPriceInr;
        return $this;
    }

    public function getLandedCost(){
        return $this->landedCost;
    }

    public function setLandedCost($landedCost){
        $this->landedCost = $landedCost;
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

    public function getMin(){
        return $this->min;
    }

    public function setMin($min){
        $this->min = $min;
        return $this;
    }

    public function getTotal(){
        return $this->total;
    }

    public function setTotal($total){
        $this->total = $total;
        return $this;
    }

    public function getLocation(){
        return $this->location;
    }

    public function setLocation($location){
        $this->location = $location;
        return $this;
    }
       public function getCountry(){
        return $this->country;
    }

    public function setCountry($location){
        $this->location = $country;
        return $this;
    }
}

?>
