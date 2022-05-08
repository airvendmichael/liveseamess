<?php

class itexService{

	private $apikey ="pse894j98saja7w80we90oddsslskldsiuh0khsds5y7f";
	private $username ="info@callphoneng.com";
	private $password ="Call@password@1";
	private $orgcode ="00101113";
	private $identifier ="callphone";
	private $pin ="4530";
	public $walletid ="81162434";
	public $channel ="B2B";
	public $output;
	public $type;
	public $ty;
	public $service;
	public $error = null;

	public function __construct($type){
		$this->type = $type;
		if($this->type == 11){$this->service = "ikedc"; $this->ty = "prepaid"; }
		if($this->type == 10){$this->service = "ikedc"; $this->ty = "postpaid"; }
		if($this->type == 13){$this->ty = "prepaid"; $this->service = "ekedc";}
		if($this->type == 14){$this->ty = "postpaid"; $this->service = "ekedc";}
		if($this->type == 15){$this->ty = "postpaid"; $this->service = "phedc";}
		if($this->type == 16){$this->ty = "prepaid"; $this->service = "phedc";}
		if($this->type == 24){$this->ty = "prepaid"; $this->service = "aedc";}
		if($this->type == 25){$this->ty = "postpaid"; $this->service = "aedc";}
	}

	private function signature($payload){
    	return HASH_HMAC("SHA256", $payload, $this->apikey);
	}

	private function authorizationNew(){
		$body = ["wallet"=>$this->walletid, "username"=>$this->username, "password"=>$this->password, "identifier"=>$this->identifier];
	    $payload = json_encode($body);

	    $result = $this->new_api_call($payload, "http://197.253.19.76:8019/api/vas/authenticate/me");
	    $data = json_decode($result);
	    return $data->data->apiToken;

	}

	public function pin(){
	        $body = ["wallet"=>$this->walletid, "username"=>$this->username, "password"=>$this->password, "pin"=>$this->pin];
	        //$payload = json_encode($body);
			//$pin = new_api_call($payload, "http://197.253.19.76:8019/api/vas/credentials/encrypt-pin");
	        //$data = json_decode($pin);
	        //$pin = $data->data->pin;
		    $pin = "ab8050714d0740b2f912ef19fc6c250da7a0484ff22ce691f82fb1a3bd9e003a";
	 	return $pin;
	}

	public function api_call($requestBody="", $endPoint=""){
	    $requestBody = json_encode($requestBody, true);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endPoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"token: ".$this->authorizationNew(),
			"signature: ".$this->signature($requestBody)
	 	));

		$response = curl_exec($ch);
	 	
		return $response;

	}

	public function new_api_call($payload, $url){

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json"
	 	));
	    
	     $response = curl_exec($ch);
	     curl_close($ch);
	     return $response;
	}

	public function productVerify($payload){
	    $output = $this->api_call($payload, "http://197.253.19.76:8019/api/v1/vas/electricity/validation");
	    $data = json_decode($output);
	    if($data->responseCode=="22"){
	    	$this->error = $data->message;
	    }
	    $this->output = $output;
	    return $data->data->productCode;
	}


}

