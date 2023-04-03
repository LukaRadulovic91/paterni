<?php

/// Bridge design pattern se koristi u Laravelu kada postoji potreba
///  da se odvoji implementacija jedne klase od njene apstrakcije.
///  Konkretno, Bridge pattern se koristi kada je potrebno izdvojiti
///  implementaciju koda koji direktno komunicira sa drugim sistemima
///  ili resursima, tako da se ona može lako promeniti bez uticaja na
///  kod koji koristi tu implementaciju.
//
//Neki od učestalih slučajeva u kojima se koristi Bridge pattern u Laravelu uključuju:
//
//  1.  Kada se koristi različiti sistem za skladištenje podataka (npr. MySQL, MongoDB, itd.) i
// potrebno je obezbediti da se aplikacija lako može prebaciti na drugi sistem za skladištenje
// podataka bez da se menjaju delovi koda koji koriste skladištenje podataka.
//
//  2.  Kada se koristi različiti sistem za slanje email poruka (npr. SendGrid, Mailgun, itd.) i
// potrebno je obezbediti da se aplikacija lako može prebaciti na drugi sistem za slanje email
// poruka bez da se menjaju delovi koda koji koriste slanje email poruka.
//
//  3.  Kada se koristi različiti sistem za autentifikaciju (npr. OAuth, JWT, itd.) i
// potrebno je obezbediti da se aplikacija lako može prebaciti na drugi sistem za
// autentifikaciju bez da se menjaju delovi koda koji koriste autentifikaciju.
//
//U ovim primerima, Bridge pattern se koristi za razdvajanje apstrakcije
// (npr. interfejsa za skladištenje podataka, slanje email poruka ili autentifikaciju)
// od konkretnih implementacija tih funkcionalnosti, tako da se omogućava zamena
// jedne implementacije sa drugom bez uticaja na kôd koji koristi tu funkcionalnost.


// MessageSender.php

namespace App\Sender;

abstract class MessageSender
{
    protected $implementation;

    public function __construct(MessageImplementation $implementation)
    {
        $this->implementation = $implementation;
    }

    abstract public function send($to, $message);
}


// MessageImplementation.php

namespace App\Sender;

interface MessageImplementation
{
    public function send($to, $message);
}


// EmailMessage.php

namespace App\Sender;

class EmailMessage implements MessageImplementation
{
    public function send($to, $message)
    {
        // Logika za slanje email poruke
    }
}


// SmsMessage.php

namespace App\Sender;

class SmsMessage implements MessageImplementation
{
    public function send($to, $message)
    {
        // Logika za slanje SMS poruke
    }
}


// PushNotification.php

namespace App\Sender;

class PushNotification implements MessageImplementation
{
    public function send($to, $message)
    {
        // Logika za slanje push notifikacije
    }
}


// MessageController.php

namespace App\Http\Controllers;

use App\Sender\EmailMessage;
use App\Sender\MessageSender;
use App\Sender\SmsMessage;
use App\Sender\PushNotification;

class MessageController extends Controller
{
    public function send()
    {
        $emailSender = new MessageSender(new EmailMessage());
        $smsSender = new MessageSender(new SmsMessage());
        $pushSender = new MessageSender(new PushNotification());

        $emailSender->send('example@example.com', 'Hello, this is an email message');
        $smsSender->send('123456789', 'Hello, this is an SMS message');
        $pushSender->send('123456789', 'Hello, this is an push notification message');
    }
}
