<?php
	/**
	 * service_spare_parts_id, service, part_no, serial_no
	 * getServiceSparePartsId() getService() getPartNo() getSerialNo()
	 */
	class ServicePartObject{

        private $service_spare_parts_id = null;
        private $service = null;
        private $part_no = null;
        private $serial_no = null;        
		
		function __construct(){
			$args = func_get_args();
			switch (func_num_args()) {
				case 4:
					self::__construct1($args[0],$args[1],$args[2],$args[3]);
					break;
				
				case 3:
					self::__construct2($args[0],$args[1],$args[2]);
					break;
			}
		}

		function __construct1($service_spare_parts_id,$service,$part_no,$serial_no){
			$this->service_spare_parts_id = $service_spare_parts_id;
			$this->service = $service;
			$this->part_no = $part_no;
			$this->serial_no = $serial_no;
	 	}

	 	function __construct2($service,$part_no,$serial_no){
			$this->service = $service;
			$this->part_no = $part_no;
			$this->serial_no = $serial_no;
	 	}
	


    /**
     * @return mixed
     */
    public function getServiceSparePartsId()
    {
        return $this->service_spare_parts_id;
    }

    /**
     * @param mixed $service_spare_parts_id
     *
     * @return self
     */
    public function setServiceSparePartsId($service_spare_parts_id)
    {
        $this->service_spare_parts_id = $service_spare_parts_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     *
     * @return self
     */
    public function setService($service)
    {
        $this->service = $service;

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
}
?>