<?php
	/**
	 * getServiceId() getMachine() getCustomer() getEngineer() getCostType() getServiceDate()
     getReportedDate() getClosedDate() getStatus() getWorkingHrs() getRepetitive() getDownHrs()
     getPhotos() getErrorCode() getErrorDescription() getAction() getRootCause() getRemarks()
     getSparePartReplace()
	 */
	class ServiceObject{
		private $service_id = null;
        private $machine = null;
        private $customer = null;
		private $engineer = null;
        private $cost_type = null;        
        private $service_date = null;	
		private $reported_date = null;
		private $closed_date = null;
        private $status = null;		
		private $working_hrs = null;
        private $repetitive = null;
		private $down_hrs = null;
        private $photos = array();
		private $error_code = null;
        private $error_description = null;
		private $action = null;
        private $root_cause = null;
		private $remarks = null;
		private $spare_part_replace = null;
        private $created_by = null;
        private $created_on = null;
        private $modified_by = null;        
        private $modified_on = null;
		
		function __construct(){
			$args = func_get_args();
			switch (func_num_args()){
                case 23:
                    //GET
                    self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],
                    $args[14],$args[15],$args[16],$args[17],$args[18],$args[19],$args[20],$args[21],$args[22]);
                    break;
                case 19:
                    //EDIT                    
                    self::__construct2($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],
                    $args[14],$args[15],$args[16],$args[17],$args[18]);
                    break;
                case 18:
                    //ADD
                    if(is_object($args[11])){
                        self::__construct3($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                        $args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],
                        $args[14],$args[15],$args[16],$args[17]);
                    }else{
                        //EDIT
                        self::__construct5($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                        $args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],
                        $args[14],$args[15],$args[16],$args[17]);
                    }
                    break;
                case 17:
                    //ADD WITHOUT PHOTOS
                    self::__construct4($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],
                    $args[6],$args[7],$args[8],$args[9],$args[10],$args[11],$args[12],$args[13],
                    $args[14],$args[15],$args[16]);
                    break;
            }    
		} 

        function __construct1($service_id,$machine,$customer,$engineer,$cost_type,
            $service_date,$reported_date,$closed_date,$status,$working_hrs,$repetitive,
            $down_hrs,ArrayObject $photos,$error_code,$error_description,$action,$root_cause,$remarks,
            $spare_part_replace,$created_by,$created_on,$modified_by,$modified_on){
            $this->service_id = $service_id;
            $this->machine = $machine;
            $this->customer = $customer;
            $this->engineer = $engineer;
            $this->cost_type = $cost_type;
            $this->service_date = $service_date;
            $this->reported_date = $reported_date;
            $this->closed_date = $closed_date;
            $this->status = $status;
            $this->working_hrs = $working_hrs;
            $this->repetitive = $repetitive;
            $this->down_hrs = $down_hrs;
            $this->photos = $photos;
            $this->error_code = $error_code;
            $this->error_description = $error_description;
            $this->action = $action;
            $this->root_cause = $root_cause;
            $this->remarks = $remarks;
            $this->spare_part_replace = $spare_part_replace;
            $this->created_by = $created_by;
            $this->created_on = $created_on;
            $this->modified_by = $modified_by;
            $this->modified_on = $modified_on;
        }

        function __construct2($service_id,$machine,$customer,$engineer,$cost_type,
            $service_date,$reported_date,$closed_date,$status,$working_hrs,$repetitive,
            $down_hrs,ArrayObject $photos,$error_code,$error_description,$action,$root_cause,$remarks,
            $spare_part_replace){
            $this->service_id = $service_id;
            $this->machine = $machine;
            $this->customer = $customer;
            $this->engineer = $engineer;
            $this->cost_type = $cost_type;
            $this->service_date = $service_date;
            $this->reported_date = $reported_date;
            $this->closed_date = $closed_date;
            $this->status = $status;
            $this->working_hrs = $working_hrs;
            $this->repetitive = $repetitive;
            $this->down_hrs = $down_hrs;
            $this->photos = $photos;
            $this->error_code = $error_code;
            $this->error_description = $error_description;
            $this->action = $action;
            $this->root_cause = $root_cause;
            $this->remarks = $remarks;
            $this->spare_part_replace = $spare_part_replace;
        }

        function __construct3($machine,$customer,$engineer,$cost_type,
            $service_date,$reported_date,$closed_date,$status,$working_hrs,$repetitive,
            $down_hrs,ArrayObject $photos,$error_code,$error_description,$action,$root_cause,$remarks,
            $spare_part_replace){ 
            $this->machine = $machine;
            $this->customer = $customer;
            $this->engineer = $engineer;
            $this->cost_type = $cost_type;
            $this->service_date = $service_date;
            $this->reported_date = $reported_date;
            $this->closed_date = $closed_date;
            $this->status = $status;
            $this->working_hrs = $working_hrs;
            $this->repetitive = $repetitive;
            $this->down_hrs = $down_hrs;
            $this->photos = $photos;
            $this->error_code = $error_code;
            $this->error_description = $error_description;
            $this->action = $action;
            $this->root_cause = $root_cause;
            $this->remarks = $remarks;
            $this->spare_part_replace = $spare_part_replace;
        }

        function __construct4($machine,$customer,$engineer,$cost_type,
            $service_date,$reported_date,$closed_date,$status,$working_hrs,$repetitive,
            $down_hrs,$error_code,$error_description,$action,$root_cause,$remarks,
            $spare_part_replace){            
            $this->machine = $machine;
            $this->customer = $customer;
            $this->engineer = $engineer;
            $this->cost_type = $cost_type;
            $this->service_date = $service_date;
            $this->reported_date = $reported_date;
            $this->closed_date = $closed_date;
            $this->status = $status;
            $this->working_hrs = $working_hrs;
            $this->repetitive = $repetitive;
            $this->down_hrs = $down_hrs;            
            $this->error_code = $error_code;
            $this->error_description = $error_description;
            $this->action = $action;
            $this->root_cause = $root_cause;
            $this->remarks = $remarks;
            $this->spare_part_replace = $spare_part_replace;
        }

        function __construct5($service_id,$machine,$customer,$engineer,$cost_type,
            $service_date,$reported_date,$closed_date,$status,$working_hrs,$repetitive,
            $down_hrs,$error_code,$error_description,$action,$root_cause,$remarks,
            $spare_part_replace){
            $this->service_id = $service_id;
            $this->machine = $machine;
            $this->customer = $customer;
            $this->engineer = $engineer;
            $this->cost_type = $cost_type;
            $this->service_date = $service_date;
            $this->reported_date = $reported_date;
            $this->closed_date = $closed_date;
            $this->status = $status;
            $this->working_hrs = $working_hrs;
            $this->repetitive = $repetitive;
            $this->down_hrs = $down_hrs;
            $this->error_code = $error_code;
            $this->error_description = $error_description;
            $this->action = $action;
            $this->root_cause = $root_cause;
            $this->remarks = $remarks;
            $this->spare_part_replace = $spare_part_replace;
        }
		

    /**
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * @param mixed $service_id
     *
     * @return self
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;

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
    public function getEngineer()
    {
        return $this->engineer;
    }

    /**
     * @param mixed $engineer
     *
     * @return self
     */
    public function setEngineer($engineer)
    {
        $this->engineer = $engineer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCostType()
    {
        return $this->cost_type;
    }

    /**
     * @param mixed $cost_type
     *
     * @return self
     */
    public function setCostType($cost_type)
    {
        $this->cost_type = $cost_type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceDate()
    {
        return $this->service_date;
    }

    /**
     * @param mixed $service_date
     *
     * @return self
     */
    public function setServiceDate($service_date)
    {
        $this->service_date = $service_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReportedDate()
    {
        return $this->reported_date;
    }

    /**
     * @param mixed $reported_date
     *
     * @return self
     */
    public function setReportedDate($reported_date)
    {
        $this->reported_date = $reported_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClosedDate()
    {
        return $this->closed_date;
    }

    /**
     * @param mixed $closed_date
     *
     * @return self
     */
    public function setClosedDate($closed_date)
    {
        $this->closed_date = $closed_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkingHrs()
    {
        return $this->working_hrs;
    }

    /**
     * @param mixed $working_hrs
     *
     * @return self
     */
    public function setWorkingHrs($working_hrs)
    {
        $this->working_hrs = $working_hrs;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRepetitive()
    {
        return $this->repetitive;
    }

    /**
     * @param mixed $repetitive
     *
     * @return self
     */
    public function setRepetitive($repetitive)
    {
        $this->repetitive = $repetitive;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDownHrs()
    {
        return $this->down_hrs;
    }

    /**
     * @param mixed $down_hrs
     *
     * @return self
     */
    public function setDownHrs($down_hrs)
    {
        $this->down_hrs = $down_hrs;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     *
     * @return self
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @param mixed $error_code
     *
     * @return self
     */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorDescription()
    {
        return $this->error_description;
    }

    /**
     * @param mixed $error_description
     *
     * @return self
     */
    public function setErrorDescription($error_description)
    {
        $this->error_description = $error_description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     *
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRootCause()
    {
        return $this->root_cause;
    }

    /**
     * @param mixed $root_cause
     *
     * @return self
     */
    public function setRootCause($root_cause)
    {
        $this->root_cause = $root_cause;

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
    public function getSparePartReplace()
    {
        return $this->spare_part_replace;
    }

    /**
     * @param mixed $spare_part_replace
     *
     * @return self
     */
    public function setSparePartReplace($spare_part_replace)
    {
        $this->spare_part_replace = $spare_part_replace;

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
}
?>