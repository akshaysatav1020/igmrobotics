<?php

	
	class DutyObject{
		private $duty_id = null;
        private $duty_type = null;
        private $po = null;
		private $bill_of_entry_no = null;
        private $bill_of_entry_date = null;        
        private $invoice_no = null;	
        private $vendor = null;
		private $euro_rate = null;
		private $inward_date = null;
        private $inward_no = null;
        private $discount = null;		
		private $duty_particulars = array();        
        private $created_by = null;
        private $created_on = null;
        private $modified_by = null;        
        private $modified_on = null;
		
		function __construct(){
			$args = func_get_args();
			switch (func_num_args()){
                case 16:
                    //GET
                    self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],$args[14],$args[15]);
                    break;
                case 12:
                    //EDIT
                    self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10],$args[11]);
                    break;
                case 11:
                    //ADD
                    self::__construct3($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10]);
                    break;
            }
		}

		function __construct1($duty_id, $duty_type, $po,$bill_of_entry_no,$bill_of_entry_date,$invoice_no,$vendor,$euro_rate,$inward_date,$inward_no,
            $discount,ArrayObject $duty_particulars,$created_by,$created_on,$modified_by,$modified_on){
			 $this->duty_id = $duty_id;
             $this->duty_type=$duty_type;
             $this->po=$po;
			 $this->bill_of_entry_no = $bill_of_entry_no;
			 $this->bill_of_entry_date = $bill_of_entry_date;
			 $this->invoice_no = $invoice_no;
			 $this->vendor = $vendor;
			 $this->euro_rate = $euro_rate;
			 $this->inward_date = $inward_date;
			$this->inward_no = $inward_no;
            $this->discount=$discount;
			$this->duty_particulars = $duty_particulars;
			$this->created_by = $created_by;
			$this->created_on = $created_on;
			$this->modified_by = $modified_by;
			$this->modified_on = $modified_on;
		}


		function __construct2($duty_id, $duty_type, $po,$bill_of_entry_no,$bill_of_entry_date,$invoice_no,$vendor,$euro_rate,$inward_date,$inward_no,
            $discount, ArrayObject $duty_particulars){
			 $this->duty_id = $duty_id;
             $this->duty_type=$duty_type;
             $this->po=$po;
			 $this->bill_of_entry_no = $bill_of_entry_no;
			 $this->bill_of_entry_date = $bill_of_entry_date;
			 $this->invoice_no = $invoice_no;
			 $this->vendor = $vendor;
			 $this->euro_rate = $euro_rate;
			 $this->inward_date = $inward_date;
			$this->inward_no = $inward_no;
            $this->discount=$discount;
			$this->duty_particulars = $duty_particulars;
		}

		function __construct3($duty_type, $po,$bill_of_entry_no,$bill_of_entry_date,$invoice_no,$vendor,$euro_rate,$inward_date,$inward_no,
            $discount, ArrayObject $duty_particulars){	
            $this->duty_type=$duty_type;
            $this->po=$po;
            $this->bill_of_entry_no = $bill_of_entry_no;
			$this->bill_of_entry_date = $bill_of_entry_date;
			$this->invoice_no = $invoice_no;
			$this->vendor = $vendor;
			$this->euro_rate = $euro_rate;
			$this->inward_date = $inward_date;
			$this->inward_no = $inward_no;
            $this->discount=$discount;
			$this->duty_particulars = $duty_particulars;
		}

    /**
     * @return mixed
     */
    public function getDutyId()
    {
        return $this->duty_id;
    }

    /**
     * @param mixed $duty_id
     *
     * @return self
     */
    public function setDutyId($duty_id)
    {
        $this->duty_id = $duty_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillOfEntryNo()
    {
        return $this->bill_of_entry_no;
    }

    /**
     * @param mixed $bill_of_entry_no
     *
     * @return self
     */
    public function setBillOfEntryNo($bill_of_entry_no)
    {
        $this->bill_of_entry_no = $bill_of_entry_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillOfEntryDate()
    {
        return $this->bill_of_entry_date;
    }

    /**
     * @param mixed $bill_of_entry_date
     *
     * @return self
     */
    public function setBillOfEntryDate($bill_of_entry_date)
    {
        $this->bill_of_entry_date = $bill_of_entry_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNo()
    {
        return $this->invoice_no;
    }

    /**
     * @param mixed $invoice_no
     *
     * @return self
     */
    public function setInvoiceNo($invoice_no)
    {
        $this->invoice_no = $invoice_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param mixed $vendor
     *
     * @return self
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEuroRate()
    {
        return $this->euro_rate;
    }

    /**
     * @param mixed $euro_rate
     *
     * @return self
     */
    public function setEuroRate($euro_rate)
    {
        $this->euro_rate = $euro_rate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInwardDate()
    {
        return $this->inward_date;
    }

    /**
     * @param mixed $inward_date
     *
     * @return self
     */
    public function setInwardDate($inward_date)
    {
        $this->inward_date = $inward_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInwardNo()
    {
        return $this->inward_no;
    }

    /**
     * @param mixed $inward_no
     *
     * @return self
     */
    public function setInwardNo($inward_no)
    {
        $this->inward_no = $inward_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDutyParticulars()
    {
        return $this->duty_particulars;
    }

    /**
     * @param mixed $duty_particulars
     *
     * @return self
     */
    public function setDutyParticulars($duty_particulars)
    {
        $this->duty_particulars = $duty_particulars;

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
    public function getPo()
    {
        return $this->po;
    }

    /**
     * @param mixed $po
     *
     * @return self
     */
    public function setPo($po)
    {
        $this->po = $po;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDutyType()
    {
        return $this->duty_type;
    }

    /**
     * @param mixed $duty_type
     *
     * @return self
     */
    public function setDutyType($duty_type)
    {
        $this->duty_type = $duty_type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     *
     * @return self
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }
}

?>