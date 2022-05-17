<?php
/**
* DnParts($id,  $dnId,$partId,$qty,$unitprice,$partTotAmount)
* getId getDnId getPartId getReason getQty getUnitprice getPartTotAmount
*/
class DnParts{
	private $id=0;
  	private $dnId=0;
  	private $partId=0;
    private $reason = null;
  	private $qty=0;
  	private $unitprice=0;
  	private $partTotAmount=0;

  	function __construct(){
    $args = func_get_args();
    switch(func_num_args()){
      case 7:
        self::__construct1($args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);
        break;
      case 6:
        self::__construct2($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
        break;
    }
  }

  function __construct1($id,  $dnId,$partId,$reason,$qty,$unitprice,$partTotAmount){
        $this->id = $id;
        $this->dnId = $dnId;
        $this->partId = $partId;
        $this->reason = $reason;
        $this->qty = $qty;
        $this->unitprice = $unitprice;
        $this->partTotAmount = $partTotAmount;
    }

    function __construct2($dnId,$partId,$reason,$qty,$unitprice,$partTotAmount){
        $this->dnId = $dnId;
        $this->partId = $partId;
        $this->reason = $reason;
        $this->qty = $qty;
        $this->unitprice = $unitprice;
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
    public function getDnId()
    {
        return $this->dnId;
    }

    /**
     * @param mixed $dnId
     *
     * @return self
     */
    public function setDnId($dnId)
    {
        $this->dnId = $dnId;

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
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     *
     * @return self
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

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
    public function getUnitprice()
    {
        return $this->unitprice;
    }

    /**
     * @param mixed $unitprice
     *
     * @return self
     */
    public function setUnitprice($unitprice)
    {
        $this->unitprice = $unitprice;

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
}
?>