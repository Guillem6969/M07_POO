<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{

    public function __construct($amount){
        $this->amount = $amount;
    }

    public function applyTransaction(BackAccountInterface $bankAccount): float{
        $balance = $bankAccount->getBalance();
        $amount = $this->getAmount();
        return $balance + $amount;
    }

    public function getTransactionInfo(): string{
        return "f";
    }

    public function getAmount(){
        return $this-> amount;
    }
   
}
