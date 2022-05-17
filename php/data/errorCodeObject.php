<?php

/**
* 
*/
class ErrorCodeObject{
	
	private $error_id = null;
	private $error_code = null;
	private $error_description = null;
	private $action = null;
    private $root_cause = null;

	function __construct(){
		$args = func_get_args();
		switch (func_num_args()) {
			case 5:
				self::__construct1($args[0], $args[1], $args[2], $args[3], $args[4]);
				break;			
			case 4:
				self::__construct2($args[0], $args[1], $args[2], $args[3]);
				break;
		}
	}

	function __construct1($error_id, $error_code, $error_description, $action,$root_cause){
		$this->error_id = $error_id;
		$this->error_code = $error_code;
		$this->error_description = $error_description;
		$this->action = $action;
        $this->root_cause=$root_cause;
	}

	function __construct2($error_code, $error_description, $action,$root_cause){
		$this->error_code = $error_code;
		$this->error_description = $error_description;
		$this->action = $action;
        $this->root_cause=$root_cause;
	}

    /**
     * @return mixed
     */
    public function getErrorId()
    {
        return $this->error_id;
    }

    /**
     * @param mixed $error_id
     *
     * @return self
     */
    public function setErrorId($error_id)
    {
        $this->error_id = $error_id;

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
}
?>