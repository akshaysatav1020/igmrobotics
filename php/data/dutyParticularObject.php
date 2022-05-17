<?php
	
	class DutyParticularObject{
		private $duty_particluar_id = null;
		private $duty_inward_no = null;
		private $part_no = null;
        private $unit_rate_euro = null;        
        private $unit_rate_inr = null;	
        private $qty = null;
		private $duty = null;
		private $clearing_charges = null;
        private $packaging = null;		
		private $forwarding_charges = null;
        private $landed_cost_per_part = null;
        private $total_landed_cost = null;
        function __construct(){
			$args = func_get_args();
			switch (func_num_args()){
                case 12:                    
                    //EDIT
                    self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10],$args[11]);
                    break;
                case 11:
                    //ADD
                    self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10]);
                    break;
            }
		}

		function __construct1($duty_particluar_id,$duty_inward_no,$part_no,$unit_rate_euro,$unit_rate_inr,$qty,$duty,$clearing_charges,$packaging,$forwarding_charges,$landed_cost_per_part,$total_landed_cost){
			$this->duty_particluar_id = $duty_particluar_id;
			$this->duty_inward_no = $duty_inward_no;
			$this->part_no = $part_no;
			$this->unit_rate_euro = $unit_rate_euro;
			$this->unit_rate_inr = $unit_rate_inr;
			$this->qty = $qty;
			$this->duty = $duty;
			$this->clearing_charges = $clearing_charges;
			$this->packaging = $packaging;
			$this->forwarding_charges = $forwarding_charges;
			$this->landed_cost_per_part = $landed_cost_per_part;
			$this->total_landed_cost = $total_landed_cost;
		}

		function __construct2($duty_inward_no,$part_no,$unit_rate_euro,$unit_rate_inr,$qty,$duty,$clearing_charges,$packaging,$forwarding_charges,$landed_cost_per_part,$total_landed_cost){
			$this->duty_inward_no = $duty_inward_no;
			$this->part_no = $part_no;
			$this->unit_rate_euro = $unit_rate_euro;
			$this->unit_rate_inr = $unit_rate_inr;
			$this->qty = $qty;
			$this->duty = $duty;
			$this->clearing_charges = $clearing_charges;
			$this->packaging = $packaging;
			$this->forwarding_charges = $forwarding_charges;
			$this->landed_cost_per_part = $landed_cost_per_part;
			$this->total_landed_cost = $total_landed_cost;
		}


	
    /**
     * @return mixed
     */
    public function getDutyParticluarId()
    {
        return $this->duty_particluar_id;
    }

    /**
     * @param mixed $duty_particluar_id
     *
     * @return self
     */
    public function setDutyParticluarId($duty_particluar_id)
    {
        $this->duty_particluar_id = $duty_particluar_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDutyInwardNo()
    {
        return $this->duty_inward_no;
    }

    /**
     * @param mixed $duty_id
     *
     * @return self
     */
    public function setDutyInwardNo($duty_inward_no)
    {
        $this->duty_inward_no = $duty_inward_no;

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
    public function getUnitRateEuro()
    {
        return $this->unit_rate_euro;
    }

    /**
     * @param mixed $unit_rate_euro
     *
     * @return self
     */
    public function setUnitRateEuro($unit_rate_euro)
    {
        $this->unit_rate_euro = $unit_rate_euro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnitRateInr()
    {
        return $this->unit_rate_inr;
    }

    /**
     * @param mixed $unit_rate_inr
     *
     * @return self
     */
    public function setUnitRateInr($unit_rate_inr)
    {
        $this->unit_rate_inr = $unit_rate_inr;

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
    public function getDuty()
    {
        return $this->duty;
    }

    /**
     * @param mixed $duty
     *
     * @return self
     */
    public function setDuty($duty)
    {
        $this->duty = $duty;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClearingCharges()
    {
        return $this->clearing_charges;
    }

    /**
     * @param mixed $clearing_charges
     *
     * @return self
     */
    public function setClearingCharges($clearing_charges)
    {
        $this->clearing_charges = $clearing_charges;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPackaging()
    {
        return $this->packaging;
    }

    /**
     * @param mixed $packaging
     *
     * @return self
     */
    public function setPackaging($packaging)
    {
        $this->packaging = $packaging;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getForwardingCharges()
    {
        return $this->forwarding_charges;
    }

    /**
     * @param mixed $forwarding_charges
     *
     * @return self
     */
    public function setForwardingCharges($forwarding_charges)
    {
        $this->forwarding_charges = $forwarding_charges;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLandedCostPerPart()
    {
        return $this->landed_cost_per_part;
    }

    /**
     * @param mixed $landed_cost_per_part
     *
     * @return self
     */
    public function setLandedCostPerPart($landed_cost_per_part)
    {
        $this->landed_cost_per_part = $landed_cost_per_part;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalLandedCost()
    {
        return $this->total_landed_cost;
    }

    /**
     * @param mixed $total_landed_cost
     *
     * @return self
     */
    public function setTotalLandedCost($total_landed_cost)
    {
        $this->total_landed_cost = $total_landed_cost;

        return $this;
    }
}
?>