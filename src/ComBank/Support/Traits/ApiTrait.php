<?php namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait
{
    public function validateEmail(string $email){

        $url = "https://api.usercheck.com/email/$email";
        //  api key"no0Z7dgqz60LvPoUy8CqXOKVZx98CbJC";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $data = json_decode($response,true);

        curl_close($ch);

        if ($data ["status"] == "200"){
            return "is valid";
        }else{
            return "Error: Invalid email adress: $email";
        }

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

        curl_close($ch);
        return $data ["result"];
    }


    public function detectFraud(){

    }
}   