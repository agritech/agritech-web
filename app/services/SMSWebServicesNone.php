<?php

class SMSWebServicesNone {
	public $app;
	
	public function __construct($app)
	{
		$this->app = $app;
	}
	
	public function sendmsg($to, $msg) {
		return NULL;
	}

}

