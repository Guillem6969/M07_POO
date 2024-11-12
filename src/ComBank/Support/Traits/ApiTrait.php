<?php namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait
{
    public function validateEmail(string $email){
        
    }


    function convertBalance(float $euros): float {
        $from = "EUR";
        $to = "USD";

        $url = "https://api.fxfeed.io/v1/convert?api_key=fxf_ghmIud6wxzpKA6cuLZTM&from=$from&to=$to&amount=$euros";

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $response = curl_exec($ch);

        $data = json_decode($response,true);

        return $data ["result"];
    }


    public function detectFraud(){

    }
}   