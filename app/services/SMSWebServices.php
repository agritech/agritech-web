<?php

class SMSWebServices {
	public $url = 'http://41.138.57.242:8001/itechsmsdev/index.php?app=ws';
	public $username = 'dossoagri';
	public $password = 'dossoagripass';
	public $app;
	
	public function __construct($app)
	{
		$this->app = $app;
	}
	
	public function sendmsg($to, $msg) {

		$ws = new Playsms\Webservices();
		$ws->url = $this->url;
		$ws->username = $this->username;
		$ws->password = $this->password;

		$ws->getToken();
		$ws->getData();
		
		if ($ws->getStatus()) {
		
			$ws->token = $ws->getData()->token;
			$ws->to = $to;
			$ws->msg = $msg;
			$ws->sendSms();
			
			return array(
					'status' => $ws->getStatus(),
					'return' => $ws->getData()
			);
		
		} else {
			return array(
					'status' => false,
					'return' => array (
										'errorCode' => $ws->getError(),
										'errorString' => $ws->getErrorString()
								)
					);
		}
	}

}

