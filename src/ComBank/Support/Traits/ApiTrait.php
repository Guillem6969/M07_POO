<?php namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait
{
    public function validateEmail(string $email){

        $url = "https://api.usercheck.com/email/$email";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $data = json_decode($response,true);

        curl_close($ch);

        if ($data ["status"] == 200){
            return true;
        }else{
            return false;
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


    public function detectFraud(BankTransactionInterface $transaction){
        
        $url = "https://673cc1d796b8dcd5f3fb7aff.mockapi.io/Fraud_API/fraudApi";

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $response = curl_exec($ch);
        $data = json_decode($response,true);

        curl_close($ch);

        $fraud = false;

        foreach($data as $key => $value ){
            if ($data[$key]['movementType']==$transaction->getTransactionInfo()){
                if($data[$key]['amount_max']<$transaction->getAmount() && $data[$key]['amount']>$transaction->getAmount()){
                    if ($data[$key]['action']==BankTransactionInterface::TRANSACTION_BLOCKED){
                        $fraud = true;
                        break;
                    }else{
                        $fraud = false;
                    }

                }
            }
        }
        
    }
}   