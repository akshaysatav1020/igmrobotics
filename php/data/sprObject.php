<?php
	/**
	 * spr_id spr_no delivery_to request_by request_date shipment_by customer machine igm_order_no non_accountable_reason igm_machine_no
	 * remarks ref_email created_by modified_by created_on modified_on
	 * getSprId(), getSprNo(), getSprDate(), getDeliveryTo(),getRequestBy(), getRequestDate(), getShipmentBy(), getCustomer(),
	 * getMachine(), getIgmOrderNo(), getNonAccountableReason(), getIgmMachineNo(), getRemarks(), getRefEmail(), getCreatedBy(), getModifiedBy(),
	 * getCreatedOn(), getModifiedOn()
	 */
	class SPRObject{
		private $spr_id = null;
		private $spr_no = null;
        private $spr_date = null;
		private $delivery_to = null;
		private $request_by = null;
		private $request_date = null;
		private $shipment_by = null;
		private $customer = null;
		private $machine = null;
        private $machine_name = null;
		private $igm_order_no = null;
        private $non_accountable_reason=null;
		private $remarks = null;
        private $error = null;
		private $ref_email = null;
		private $created_by = null;
		private $modified_by = null;
		private $created_on = null;
		private $modified_on = null;
		private $sprParts = array();
		function __construct(){
			$args = func_get_args();
			switch (func_num_args()) {
				case 20:
					self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16],$args[17],$args[18],$args[19]);
					break;				
				case 17:
                    if(is_object($args[16])){
					   self::__construct3($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16]);
                    }else{
                        self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15],$args[16]);
                    break;
                    }
					break;
			}
		}

		function __construct1($spr_id, $spr_no, $spr_date,$delivery_to,$request_by,$request_date,$shipment_by,$customer,$machine, $machine_name, $igm_order_no,$non_accountable_reason,$remarks,$error,$ref_email,$created_by,$modified_by,$created_on,$modified_on,ArrayObject $sprParts){
			$this->spr_id = $spr_id;
			$this->spr_no = $spr_no;
            $this->spr_date = $spr_date;
			$this->delivery_to = $delivery_to;
			$this->request_by = $request_by;
			$this->request_date = $request_date;
			$this->shipment_by = $shipment_by;
			$this->customer = $customer;
			$this->machine = $machine;
            $this->machine_name = $machine_name;
			$this->igm_order_no = $igm_order_no;
            $this->non_accountable_reason = $non_accountable_reason;
			$this->remarks = $remarks;
            $this->error = $error;
			$this->ref_email = $ref_email;
			$this->created_by = $created_by;
			$this->modified_by = $modified_by;
			$this->created_on = $created_on;
			$this->modified_on = $modified_on;
			$this->sprParts = $sprParts;
		}
		
		function __construct2($spr_id, $spr_no, $spr_date,$delivery_to,$request_by,$request_date,$shipment_by,$customer,$machine,$machine_name,$igm_order_no,$non_accountable_reason,$remarks,$error,$ref_email,$created_by,$modified_by){
			$this->spr_id = $spr_id;
            $this->spr_no = $spr_no;
            $this->spr_date = $spr_date;
			$this->delivery_to = $delivery_to;
			$this->request_by = $request_by;
			$this->request_date = $request_date;
			$this->shipment_by = $shipment_by;
			$this->customer = $customer;
			$this->machine = $machine;
            $this->machine_name = $machine_name;
			$this->igm_order_no = $igm_order_no;
            $this->non_accountable_reason = $non_accountable_reason;
			$this->remarks = $remarks;
            $this->error = $error;
			$this->ref_email = $ref_email;
			$this->created_by = $created_by;
			$this->modified_by = $modified_by;
		}

		function __construct3($spr_no, $spr_date, $delivery_to,$request_by,$request_date,$shipment_by,$customer,$machine,$machine_name,$igm_order_no,$non_accountable_reason,$remarks,$error,$ref_email,$created_by,$modified_by,ArrayObject $sprParts){
			$this->spr_no = $spr_no;
            $this->spr_date = $spr_date;            
			$this->delivery_to = $delivery_to;
			$this->request_by = $request_by;
			$this->request_date = $request_date;
			$this->shipment_by = $shipment_by;
			$this->customer = $customer;
			$this->machine = $machine;
            $this->machine_name = $machine_name;
			$this->igm_order_no = $igm_order_no;
            $this->non_accountable_reason = $non_accountable_reason;
			$this->remarks = $remarks;
            $this->error = $error;
			$this->ref_email = $ref_email;
			$this->created_by = $created_by;
			$this->modified_by = $modified_by;
			$this->sprParts = $sprParts;
		}


    /**
     * @return mixed
     */
    public function getSprId()
    {
        return $this->spr_id;
    }

    /**
     * @param mixed $spr_id
     *
     * @return self
     */
    public function setSprId($spr_id)
    {
        $this->spr_id = $spr_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSprNo()
    {
        return $this->spr_no;
    }

    /**
     * @param mixed $spr_no
     *
     * @return self
     */
    public function setSprNo($spr_no)
    {
        $this->spr_no = $spr_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSprDate()
    {
        return $this->spr_date;
    }

    /**
     * @param mixed $spr_date
     *
     * @return self
     */
    public function setSprDate($spr_date)
    {
        $this->spr_date = $spr_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliveryTo()
    {
        return $this->delivery_to;
    }

    /**
     * @param mixed $delivery_to
     *
     * @return self
     */
    public function setDeliveryTo($delivery_to)
    {
        $this->delivery_to = $delivery_to;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestBy()
    {
        return $this->request_by;
    }

    /**
     * @param mixed $request_by
     *
     * @return self
     */
    public function setRequestBy($request_by)
    {
        $this->request_by = $request_by;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestDate()
    {
        return $this->request_date;
    }

    /**
     * @param mixed $request_date
     *
     * @return self
     */
    public function setRequestDate($request_date)
    {
        $this->request_date = $request_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShipmentBy()
    {
        return $this->shipment_by;
    }

    /**
     * @param mixed $shipment_by
     *
     * @return self
     */
    public function setShipmentBy($shipment_by)
    {
        $this->shipment_by = $shipment_by;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     *
     * @return self
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMachine()
    {
        return $this->machine;
    }

    /**
     * @param mixed $machine
     *
     * @return self
     */
    public function setMachine($machine)
    {
        $this->machine = $machine;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIgmOrderNo()
    {
        return $this->igm_order_no;
    }

    /**
     * @param mixed $igm_order_no
     *
     * @return self
     */
    public function setIgmOrderNo($igm_order_no)
    {
        $this->igm_order_no = $igm_order_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNonAccountableReason()
    {
        return $this->non_accountable_reason;
    }

    /**
     * @param mixed $non_accountable_reason
     *
     * @return self
     */
    public function setNonAccountableReason($non_accountable_reason)
    {
        $this->non_accountable_reason = $non_accountable_reason;

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
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     *
     * @return self
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefEmail()
    {
        return $this->ref_email;
    }

    /**
     * @param mixed $ref_email
     *
     * @return self
     */
    public function setRefEmail($ref_email)
    {
        $this->ref_email = $ref_email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     *
     * @return self
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * @param mixed $modified_by
     *
     * @return self
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->created_on;
    }

    /**
     * @param mixed $created_on
     *
     * @return self
     */
    public function setCreatedOn($created_on)
    {
        $this->created_on = $created_on;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedOn()
    {
        return $this->modified_on;
    }

    /**
     * @param mixed $modified_on
     *
     * @return self
     */
    public function setModifiedOn($modified_on)
    {
        $this->modified_on = $modified_on;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSprParts()
    {
        return $this->sprParts;
    }

    /**
     * @param mixed $sprParts
     *
     * @return self
     */
    public function setSprParts($sprParts)
    {
        $this->sprParts = $sprParts;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getMachineName()
    {
        return $this->machine_name;
    }

    /**
     * @param mixed $machine_name
     *
     * @return self
     */
    public function setMachineName($machine_name)
    {
        $this->machine_name = $machine_name;

        return $this;
    }
    
}
?>