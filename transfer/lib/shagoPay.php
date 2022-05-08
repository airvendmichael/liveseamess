<?php

//Class SHago Pay. This contains all shago transactions.
class SHAGOAPI{

    //private $url = "http://34.68.51.255/shago/public/api/test/b2b";
    
    //private $hash = "c1df88d180d0163fc53f4efde6288a2c87a2ceaaefae0685fd4a8c01b217e70d";
     private $hash = "3e91d508e1309963e29074a3a61d1a1c5810854fe5ec246f6c1c673e4f166f24";
     private $url = "https://shagopayments.com/api/live/b2b";
    public $payload;
    private $type="";
    private $serviceCode="";
    private $disco="";

    public function __construct($type, $stat)
    {
        //stat 0 = product or 1 =  verify or  2 = vend
        $bet = [101=>"Bet9ja",102=>"BangBet", 103=>"NairaBet", 104=>"SupaBet", 105=>"CloudBet", 106=>"BetLion", 107=>"1xBet", 108=>"MerryBet", 109=>"BetWay", 110=>"BetLand", 111=>"BetKing", 112=>"LiveScoreBet", 113=>"NaijaBet" ];
        if($stat == 0){
            if($type == 130){ $this->serviceCode="NBV";} //NTEL
            if($type == 41){ $this->serviceCode="SHL";} //SHOW MAX
            if($type == 1000){ $this->serviceCode="WBL";} //MONEY TRANSFER
        }
        if($stat == 1){
            if($type == 21){ $this->type = "PREPAID"; $this->serviceCode = "AOV";  $this->disco = "EEDC";}
            if($type == 22){ $this->type = "POSTPAID"; $this->serviceCode = "AOV"; $this->disco = "EEDC";}
            if($type >=101 && $type <=120){$this->type=$bet[$type]; $this->serviceCode="BEV";} //BET
            if($type == 1000){ $this->serviceCode="WBV";} //MONEY TRANSFER
        }
        if($stat == 2){
            if($type == 21){ $this->type = "PREPAID"; $this->serviceCode = "AOB";  $this->disco = "EEDC";}
            if($type == 22){ $this->type = "POSTPAID"; $this->serviceCode = "AOB"; $this->disco = "EEDC";}
            if($type >=101 && $type <=120){$this->type=$bet[$type]; $this->serviceCode="BEP";} //BET
            if($type == 131){  $this->serviceCode = "NVT";} //NTEL PREPAID
            if($type == 130){  $this->serviceCode = "NBP";} //NTEL DATABUNDLE
            if($type == 1000){ $this->serviceCode="WBB";} //MONEY TRANSFER

        }

        
    }
    private function shagoApi(){
        
        $content = json_encode($this->payload);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","hashKey:$this->hash"));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$content);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
        
                return $response;
    }


    //Product Call
    public function product(){
        $this->payload = array("serviceCode"=>$this->serviceCode);
        return $this->shagoApi();
    }
    //Verify Details
    public function verify($data){
        $this->payload = array("meterNo"=>$data["account"],"customerId"=>$data["account"],"serviceCode"=>$this->serviceCode,"disco"=>$this->disco,"type"=>$this->type, "amount"=>$data["amount"],"bank_account"=>$data["bank_account"],"bank_name"=>$data["bank_name"],"bin"=>$data["bin"]);
        return $this->shagoApi();
    }
    
    //Vend Electricity.....
    public function vend($data){
         $this->payload = array("reference"=>$data["transaction_id"],"request_id"=>$data["id"],"amount"=>$data["amount"],"address"=>$data["customeraddress"],
         "name"=>$data["customername"],"code"=>$data["customernumber"],"meterNo"=>$data["account"],"customerId"=>$data["account"],"serviceCode"=>$this->serviceCode,"disco"=>$this->disco,"type"=>$this->type);
         return $this->shagoApi();
    }

    //Vend Money
    public function vendMoney($data){
        $this->payload = array("reference"=>$data["reference"], "request_id"=>$data["transaction_id"], "serviceCode"=>$this->serviceCode);
        return $this->shagoApi();
    }
}


