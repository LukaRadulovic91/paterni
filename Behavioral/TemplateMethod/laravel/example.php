<?php

///Template method design pattern u Laravelu se koristi
///  kada imamo nekoliko sličnih klasa koje imaju slične funkcionalnosti,
///  ali se razlikuju po nekim detaljima implementacije.
///  Umesto da dupliramo kod i povećavamo količinu posla potrebnu za održavanje koda,
///  možemo koristiti Template method da definišemo okvir za izvršavanje zajedničke funkcionalnosti,
///  dok se detalji implementacije dele u odvojenim klasama.
//
//Primer gde bi se Template method mogao primeniti u Laravelu je
// kod implementacije različitih tipova autentifikacije.
// Na primer, Laravel omogućava autentifikaciju putem email/password kombinacije,
// putem username/password kombinacije, kao i putem API tokena.
// Svaki od ovih tipova autentifikacije ima slične korake u procesu autentifikacije
// (provera korisničkih podataka, provera uslova za autentifikaciju, itd.),
// ali se razlikuju po detaljima implementacije.
//
//U ovom slučaju, možemo definisati apstraktnu klasu AbstractAuthenticator
// koja definiše zajednički okvir za autentifikaciju, a zatim kreirati konkretne klase
// EmailAuthenticator, UsernameAuthenticator i ApiTokenAuthenticator koje nasleđuju ovu klasu
// i implementiraju specifične korake autentifikacije. Na ovaj način možemo izbeći dupliranje koda
// i pojednostaviti održavanje aplikacije.

///Pretpostavimo da imamo sistem za obradu transakcija u kojem različite
///  vrste transakcija zahtevaju različite korake za obradu,
///  ali imaju i neke zajedničke korake. Kako bi izbegli dupliciranje koda i
///  olakšali održavanje, možemo koristiti template method pattern.
///

abstract class Transaction
{
    protected $amount;
    protected $description;

    public function __construct($amount, $description)
    {
        $this->amount = $amount;
        $this->description = $description;
    }

    public function process()
    {
        $this->validate();
        $this->beforeProcess();
        $this->processTransaction();
        $this->afterProcess();
    }

    protected function validate()
    {
        // zajednički korak za sve transakcije
    }

    protected function beforeProcess()
    {
        // zajednički korak za sve transakcije
    }

    protected abstract function processTransaction();

    protected function afterProcess()
    {
        // zajednički korak za sve transakcije
    }
}

class BankTransaction extends Transaction
{
    protected function processTransaction()
    {
        // specifični koraci za obradu bankovne transakcije
    }
}

class PaypalTransaction extends Transaction
{
    protected function processTransaction()
    {
        // specifični koraci za obradu PayPal transakcije
    }
}

class BitcoinTransaction extends Transaction
{
    protected function processTransaction()
    {
        // specifični koraci za obradu Bitcoin transakcije
    }
}


$transaction = new BankTransaction($amount, $description);
$transaction->process();


