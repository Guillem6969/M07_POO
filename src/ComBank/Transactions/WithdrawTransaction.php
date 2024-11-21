<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Support\Traits\ApiTrait;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{

    use ApiTrait;

    public function __construct($amount){
        parent::validateAmount($amount);
        $this->amount = $amount;
    }

    public function applyTransaction(BackAccountInterface $bankAccount): float{
        
        if($this->detectFraud(transaction: $this)){
            throw new FailedTransactionException('Blocked by possible fraud');
        }

        $balance = $bankAccount->getBalance();
        $amount = $this->getAmount();
        $next_balance = $balance - $amount;

        $overdraft = $bankAccount->getOverdraft()->isGrantOverdraftFunds($next_balance);

        if($next_balance < 0){
            if($overdraft){
                return $next_balance;
            }
            else{
                throw new InvalidOverdraftFundsException("Insuficient balance to complete the withdrawal");
            }
        }

        return $next_balance;
    }

    public function getTransactionInfo(): string{
        return "WITHDRAW_TRANSACTION";
    }

    public function getAmount(){
        return $this->amount;
    }
}
