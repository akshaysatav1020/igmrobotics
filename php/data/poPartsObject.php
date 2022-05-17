<?php
/**
 * `id`, `poId`, `partId`, `qty`, `unitprice`, partTotAmt
 */
class poPartsObject{

  private $id = 0;
  private $poId = 0;
  private $partId = 0;
  private $qty = 0;
  private $unitprice = 0;
  private $partTotAmt = 0;

  function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
      case 6:
        self::__construct1($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
        break;
      case 5:
        self::__construct2($args[0], $args[1], $args[2], $args[3], $args[4]);
        break;
    }
  }

  function __construct1($id, $poId, $partId, $qty, $unitprice, $partTotAmt){
    $this->id = $id;
    $this->poId = $poId;
    $this->partId = $partId;
    $this->qty = $qty;
    $this->unitprice = $unitprice;
    $this->partTotAmt = $partTotAmt;
  }

  function __construct2($poId, $partId, $qty, $unitprice, $partTotAmt){
    $this->poId = $poId;
    $this->partId = $partId;
    $this->qty = $qty;
    $this->unitprice = $unitprice;
    $this->partTotAmt = $partTotAmt;
  }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getPoId(){
        return $this->poId;
    }

    public function setPoId($poId){
        $this->poId = $poId;
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

    public function getPartTotAmt(){
        return $this->partTotAmt;
    }

    public function setPartTotAmt($partTotAmt){
        $this->partTotAmt = $partTotAmt;
        return $this;
    }

}

?>
