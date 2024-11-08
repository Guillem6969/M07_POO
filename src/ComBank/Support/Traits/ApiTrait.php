<?php namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait
{
    public function validateEmail(string $email){
        
    }

    function convertBalance(float $euros): float {
        $ch = curl_init();
        $api = "https://manyapis.com/products/currency/eur-to-usd-rate?amount=" . $euros;
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => 'sk_47537c68824e436695b624303457317a',
            CURLOPT_SSL_VERIFYPEER => false,
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $convertJson = json_decode($result);
         return $convertJson->convertedAmount;
        }

    public function detectFraud(){

    }
}   