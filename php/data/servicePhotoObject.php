<?php
	/**
	 * getServicePhotoId() getService() getUrl()
	 */
	class ServicePhoto{
		private $service_photo_id = null;
		private $service = null;
		private $url = null;

		function __construct(){
			$args = func_get_args();
			switch (func_num_args()) {
				case 3:
					self::__construct1($args[0],$args[1],$args[2]);
					break;
				
				case 2:
					self::__construct2($args[0],$args[1]);
					break;
			}
		}

		function __construct1($service_photo_id,$service,$url){
			$this->service_photo_id = $service_photo_id;
			$this->service = $service;
			$this->url = $url;
		}

		function __construct2($service,$url){
			$this->service = $service;
			$this->url = $url;
		}


	
    /**
     * @return mixed
     */
    public function getServicePhotoId()
    {
        return $this->service_photo_id;
    }

    /**
     * @param mixed $service_photo_id
     *
     * @return self
     */
    public function setServicePhotoId($service_photo_id)
    {
        $this->service_photo_id = $service_photo_id;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
?>