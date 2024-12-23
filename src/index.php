<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Bank\NationalBankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Person\Person;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;

require_once 'bootstrap.php';


    //---[Bank account 1]---/
    // create a new account1 with balance 400
pl('--------- [Start testing bank account #1, No overdraft] --------');


try {
    $bankAccount1 = new BankAccount(400);
    // show balance account
    
    pl('My balance '. $bankAccount1->getBalance());

    // close account
    $bankAccount1->closeAccount();
    
    // reopen account
    $bankAccount1->reopenAccount();
    

    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25));
    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600));
   
    
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());




//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    $bankAccount2 = new BankAccount(0, new SilverOverdraft());
    $bankAccount2->setBalance(200);
    // show balance account
    pl('My balance : '.    $bankAccount2->getBalance());

    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(bankTransaction: new WithdrawTransaction(50));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(bankTransaction: new WithdrawTransaction(120));

    
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(bankTransaction: new WithdrawTransaction(20));

} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());
$bankAccount2->closeAccount();

try {
   $bankAccount2->closeAccount();
} catch (BankAccountException $e) {
    pl($e->getMessage());
}

    //---[Bank account National---/
    // create a new NationalAccount with balance 500

    pl('--------- [Start testing bank national account (no conversion)] --------');

    $nationalAccount = new NationalBankAccount(500 , null, "EUR");
    pl('My balance '. $nationalAccount->getBalance() .' € ('. $nationalAccount->getCurrency() .')');

    //---[Bank account International]---/
    // create a new International Account with balance 300

    pl('--------- [Start testing bank International account (Dollar conversion)] --------');
    $internationalAccount = new InternationalBankAccount(300, null, "EUR");

    pl('My balance '. $internationalAccount->getBalance() . ' € ('. $internationalAccount->getCurrency() .')');

    $currentBalance = $internationalAccount->getBalance();
    pl('Converting balance to Dollars '. $internationalAccount->convertBalance($currentBalance));

    //---[PERSON'S EMAIL]---/
    // create a new Person  and test his/her email

    pl('--------- [Start testing EMAIL] --------');
    $person1 = new Person("john.doe@example.com", "54559040G", "Guillem", null);

    pl('--------- [Start testing EMAIL] --------');
    $person1 = new Person("john.doe@invalid-email", "54559040G", "Guillem", null);


    // Test of different transactions
     //---[Bank account 3]---/
    // Account with balance 5000

    pl('--------- [Start testing bank account (Fraud API)] --------');
    $bankAccount3 = new BankAccount(5001);

    pl(mixed: 'Doing transaction withdrawal (-5001) with current balance : ' . $bankAccount3->getBalance());
    try{
        $bankAccount3->transaction(bankTransaction:new WithdrawTransaction(5001) );

    } catch(FailedTransactionException $e){
        pl($e->getMessage());
    }
    pl('My balance '. $bankAccount3->getBalance() . ' € ('. $bankAccount3->getCurrency() .')');


    pl(mixed: 'Doing transaction withdrawal (-5000) with current balance : ' . $bankAccount3->getBalance());
    try{
        $bankAccount3->transaction(bankTransaction:new WithdrawTransaction(5000) );

    } catch(FailedTransactionException $e){
        pl($e->getMessage());
    }

    pl('My balance '. $bankAccount3->getBalance() . ' € ('. $bankAccount3->getCurrency() .')');


    pl(mixed: 'Doing transaction deposit (+20000) with current balance : ' . $bankAccount3->getBalance());
    try{
        $bankAccount3->transaction(bankTransaction:new DepositTransaction(20000) );

    } catch(FailedTransactionException $e){
        pl($e->getMessage());
    }
    pl('My balance '. $bankAccount3->getBalance() . ' € ('. $bankAccount3->getCurrency() .')');


    pl(mixed: 'Doing transaction deposit (+20001) with current balance : ' . $bankAccount3->getBalance());
    try{
        $bankAccount3->transaction(bankTransaction:new DepositTransaction(20001) );

    } catch(FailedTransactionException $e){
        pl($e->getMessage());
    }
    pl('My balance '. $bankAccount3->getBalance() . ' € ('. $bankAccount3->getCurrency() .')');



    //---[PERSON'S PHONE]---/
    // create a new Person  and test his/her email

    pl('--------- [Start testing PHONE] --------');
    $person1 = new Person(null, "54559040G", "Guillem", "+34607600775");

    pl('--------- [Start testing PHONE] --------');
    $person1 = new Person(null, "54559040G", "Guillem", "1234abc13425");




