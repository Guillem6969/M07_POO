<?php namespace ComBank\Transactions\Contracts;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:29 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;

interface BankTransactionInterface 
{
    const TRANSACTION_BLOCKED = 'blocked';
    const TRANSACTION_ALLOWED = 'allowed';

    public function applyTransaction(BackAccountInterface $bankAccount): float;

    public function getTransactionInfo(): string;

    public function getAmount();

    

}
