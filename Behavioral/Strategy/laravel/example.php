<?php

///Strategy design pattern u Laravelu se može koristiti u situacijama
///  kada se različiti algoritmi ili strategije koriste za izvršavanje istog zadatka.
///  Na primer, ako imate aplikaciju za prodaju proizvoda koja mora da podržava
///  različite načine plaćanja (kreditne kartice, PayPal, bankovni transfer itd.),
///  možete koristiti Strategy pattern kako biste omogućili da se odabere odgovarajuća
///  strategija plaćanja u zavisnosti od izbora korisnika.
//
//Ovaj pattern vam omogućava da izdvojite specifične algoritme u zasebne klase koje
// se mogu lako zameniti jedna za drugu bez uticaja na kôd koji koristi strategiju.
// To vam daje fleksibilnost u implementaciji i omogućava vam da se prilagodite promenama
// u zahtevima klijenata.
//
//Ukratko, Strategy design pattern se koristi kada treba da se podrže različiti algoritmi
// ili strategije za izvršavanje istog zadatka, a kôd mora biti fleksibilan i lako održiv.

interface PaymentStrategy
{
    public function pay($amount);
}

class CreditCardStrategy implements PaymentStrategy
{
    public function pay($amount)
    {
        // implementacija plaćanja putem kreditne kartice
    }
}

class PayPalStrategy implements PaymentStrategy
{
    public function pay($amount)
    {
        // implementacija plaćanja putem PayPal-a
    }
}

class BitcoinStrategy implements PaymentStrategy
{
    public function pay($amount)
    {
        // implementacija plaćanja putem Bitcoina
    }
}


class PaymentContext
{
    private $strategy;

    public function __construct(PaymentStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setPaymentStrategy(PaymentStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function pay($amount)
    {
        return $this->strategy->pay($amount);
    }
}


class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $paymentMethod = $request->get('payment_method');
        $amount = $request->get('amount');

        switch ($paymentMethod) {
            case 'credit_card':
                $paymentStrategy = new CreditCardStrategy();
                break;
            case 'paypal':
                $paymentStrategy = new PayPalStrategy();
                break;
            case 'bitcoin':
                $paymentStrategy = new BitcoinStrategy();
                break;
            default:
                throw new Exception('Invalid payment method selected');
        }

        $paymentContext = new PaymentContext($paymentStrategy);
        $paymentContext->pay($amount);
    }
}


