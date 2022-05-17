<?php
	/**
	 * spr_part_id, spr, quantity, part_no, serial_no, description, remarks, used_from
	 * getSprPartId() getSpr() getQuantity() getPartNo() getSerialNo() getDescription() getRemarks()
     * getUsedFrom()
	 */
	class SPRParts{
		private $spr_part_id = null;
		private $spr = null;
		private $quantity = null;
		private $part_no = null;
        private $serial_no = null;
		private $description = null;
		private $remarks = null;
        private $used_from = null;
		function __construct(){
			$args = func_get_args();
			switch (func_num_args()) {
				case 8:
					self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7]);
					break;
				
				case 7:
					self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]);
					break;
				case 6:
					self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]);
					break;
			}
		}

		function __construct1($spr_part_id, $spr,$quantity,$part_no,$serial_no,$description,$remarks,$used_from){
			$this->spr_part_id = $spr_part_id;
			$this->spr = $spr;
			$this->quantity = $quantity;
			$this->part_no = $part_no;
            $this->serial_no = $serial_no;
			$this->description = $description;
			$this->remarks = $remarks;
            $this->used_from = $used_from;
		}

		function __construct2($spr,$quantity,$part_no,$serial_no,$description,$remarks,$used_from){			
			$this->spr = $spr;
			$this->quantity = $quantity;
			$this->part_no = $part_no;
            $this->serial_no = $serial_no;
			$this->description = $description;
			$this->remarks = $remarks;
            $this->used_from = $used_from;
		}

		function __construct3($quantity,$part_no,$serial_no,$description,$remarks,$used_from){			
			$this->quantity = $quantity;
			$this->part_no = $part_no;
            $this->serial_no = $serial_no;
			$this->description = $description;
			$this->remarks = $remarks;
            $this->used_from = $used_from;			
		}

    

    /**
     * @return mixed
     */
    public function getSprPartId()
    {
        return $this->spr_part_id;
    }

    /**
     * @param mixed $spr_part_id
     *
     * @return self
     */
    public function setSprPartId($spr_part_id)
    {
        $this->spr_part_id = $spr_part_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpr()
    {
        return $this->spr;
    }

    /**
     * @param mixed $spr
     *
     * @return self
     */
    public function setSpr($spr)
    {
        $this->spr = $spr;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     *
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPartNo()
    {
        return $this->part_no;
    }

    /**
     * @param mixed $part_no
     *
     * @return self
     */
    public function setPartNo($part_no)
    {
        $this->part_no = $part_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerialNo()
    {
        return $this->serial_no;
    }

    /**
     * @param mixed $serial_no
     *
     * @return self
     */
    public function setSerialNo($serial_no)
    {
        $this->serial_no = $serial_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     *
     * @return self
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsedFrom()
    {
        return $this->used_from;
    }

    /**
     * @param mixed $used_from
     *
     * @return self
     */
    public function setUsedFrom($used_from)
    {
        $this->used_from = $used_from;

        return $this;
    }
}
?>