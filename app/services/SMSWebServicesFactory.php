<?php
class SMSWebServicesFactory {
		
	public function __construct($app)
	{
		$this->app = $app;
	}
	
	public function getSMSWebServices($gateway){
		if($gateway == 'PLAYSMS'){
			return new SMSWebServices($this->app);
		}else if($gateway == 'ORANGE'){
			return new SMSWebServicesOrange($this->app);
		}else{
			return new SMSWebServicesNone($this->app);
		}
	}
}