<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Support\Traits\ApiTrait;
class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{

    use ApiTrait;
    public function __construct($amount)
    {
        parent::validateAmount($amount);
        $this->amount = $amount;
    }

    public function applyTransaction(BackAccountInterface $bankAccount): float
    {
        if($this->detectFraud(transaction: $this)){
            throw new FailedTransactionException('Blocked by possible fraud');
        }
        $balance = $bankAccount->getBalance();
        $amount = $this->getAmount();
        return $balance + $amount;
    }

    public function getTransactionInfo(): string
    {
        return "DEPOSIT_TRANSACTION";
    }   
}
