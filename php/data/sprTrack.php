<?php
 /**
  * 
  */
 class SPRTrack{
 	private $spr_track_id=0;
  	private $spr_no=0;
  	private $part_no=0;
    private $requested = 0;
  	private $received=0;
  	private $faulty=0;
  	private $serial_no=0;
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
	function __construct1($spr_track_id, $spr_no, $part_no, $requested, $received, $faulty, $serial_no){
		$this->spr_track_id = $spr_track_id;
		$this->spr_no = $spr_no;
		$this->part_no = $part_no;
		$this->requested = $requested;
		$this->received = $received;
		$this->faulty = $faulty; 
		$this->serial_no = $serial_no;
	}

	function __construct2($spr_no, $part_no, $requested, $received, $faulty, $serial_no){
		$this->spr_no = $spr_no;
		$this->part_no = $part_no;
		$this->requested = $requested;
		$this->received = $received;
		$this->faulty = $faulty; 
		$this->serial_no = $serial_no;
	}
 	
    /**
     * @return mixed
     */
    public function getSprTrackId()
    {
        return $this->spr_track_id;
    }

    /**
     * @param mixed $spr_track_id
     *
     * @return self
     */
    public function setSprTrackId($spr_track_id)
    {
        $this->spr_track_id = $spr_track_id;

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
    public function getRequested()
    {
        return $this->requested;
    }

    /**
     * @param mixed $requested
     *
     * @return self
     */
    public function setRequested($requested)
    {
        $this->requested = $requested;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * @param mixed $received
     *
     * @return self
     */
    public function setReceived($received)
    {
        $this->received = $received;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFaulty()
    {
        return $this->faulty;
    }

    /**
     * @param mixed $faulty
     *
     * @return self
     */
    public function setFaulty($faulty)
    {
        $this->faulty = $faulty;

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