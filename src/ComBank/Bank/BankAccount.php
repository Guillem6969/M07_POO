<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use PhpParser\Node\Stmt\Return_;

class BankAccount implements BackAccountInterface
{
    private $balance;
    private $status;
    
    private $overdraft;


    function __construct($balance, OverdraftInterface $overdraft = null){
        $this->balance = $balance;
        $this->status = BackAccountInterface::STATUS_OPEN;

        if( $overdraft === null ){
            $this->overdraft = new NoOverdraft();
        } else {
            $this->overdraft = $overdraft;
        }

    }

    public function transaction(BankTransactionInterface $bankTransaction): void {
        try{
            $this->setBalance($bankTransaction->applyTransaction($this));
        }catch(InvalidOverdraftFundsException $e){
            throw new FailedTransactionException($e->getMessage(), $e->getCode(), $e);
        }
    }
    
    //--------------------------------------------------------

    public function openAccount() : bool{
        return true;
    }

    //--------------------------------------------------------

    public function reopenAccount() : void{
        $this->status = BackAccountInterface::STATUS_OPEN;
        pl('My account is now reopened');
    }

    //--------------------------------------------------------

    public function closeAccount() : void{
        $this->status = BackAccountInterface::STATUS_CLOSED;
        pl('My account is now closed');
    }

    //--------------------------------------------------------

    public function getBalance() :float{
        return $this->balance;
    }

    //--------------------------------------------------------

    public function getOverdraft() :OverdraftInterface{
        return $this->overdraft; 
    }

    //--------------------------------------------------------

    public function applyOverdraft(OverdraftInterface $overdraft): void{
        $this->overdraft = $overdraft;
    }

    //--------------------------------------------------------

    public function setBalance($float) : void{
        $this->balance = $float;

    }


}


