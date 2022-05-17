<?php
	/**
	 * machine_id, machine_no, machine_name, machine_drawing, customer
	 */
	class MachineObject{
		private $machine_id = null;
		private $machine_no = null;
		private $machine_name = null;
		private $location = null;
		private $customer = null;
		function __construct(){
			$args = func_get_args();
			switch (func_num_args()) {
				case 5:
					self::__construct1($args[0],$args[1],$args[2],$args[3],$args[4]);
					break;
				case 4:
					self::__construct2($args[0],$args[1],$args[2],$args[3]);
					break;
			}
		}

		function __construct1($machine_id, $machine_no, $machine_name, $location, $customer){
			$this->machine_id = $machine_id;
			$this->machine_no = $machine_no;
			$this->machine_name = $machine_name;
			$this->location = $location;
			$this->customer = $customer;
		}

		function __construct2($machine_no, $machine_name, $location, $customer){
			$this->machine_no = $machine_no;
			$this->machine_name = $machine_name;
			$this->location = $location;
			$this->customer = $customer;
		}

		
	
    /**
     * @return mixed
     */
    public function getMachineId()
    {
        return $this->machine_id;
    }

    /**
     * @param mixed $machine_id
     *
     * @return self
     */
    public function setMachineId($machine_id)
    {
        $this->machine_id = $machine_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMachineNo()
    {
        return $this->machine_no;
    }

    /**
     * @param mixed $machine_no
     *
     * @return self
     */
    public function setMachineNo($machine_no)
    {
        $this->machine_no = $machine_no;

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

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $Location
     *
     * @return self
     */
    public function setLocation($location)
    {
        $this->location = $location;

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
}
?>