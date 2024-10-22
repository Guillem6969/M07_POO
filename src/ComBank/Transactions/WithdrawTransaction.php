<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{

    public function __construct($amount){
        $this->amount = $amount;
    }

    public function applyTransaction(BackAccountInterface $bankAccount): float{
        if(!$bankAccount->getBalance() < 0)
        {
            $balance = $bankAccount->getBalance();
            $amount = $this->getAmount();
            return $balance - $amount;
        }
        else
        {
            echo("Error transaction: Insuficient balance to complete the withdrawal");
        }
        return $bankAccount->getBalance();
    }

    public function getTransactionInfo(): string{
        return "f";
    }

    public function getAmount(){
        return $this->amount;
    }
}
