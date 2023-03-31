<?php


namespace App\Mediators;

use App\Publishers\MessagePublisher;
use App\Subscribers\MessageSubscriber;

class MessageMediator
{
    protected $subscribers = [];

    public function subscribe(MessageSubscriber $subscriber)
    {
        $this->subscribers[] = $subscriber;
    }

    public function publish(MessagePublisher $publisher, $message)
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->handleMessage($message);
        }
    }
}


namespace App\Publishers;

use App\Mediators\MessageMediator;

class MessagePublisher
{
    protected $mediator;

    public function __construct(MessageMediator $mediator)
    {
        $this->mediator = $mediator;
    }

    public function publish($message)
    {
        // Publish message to mediator
        $this->mediator->publish($this, $message);
    }
}


namespace App\Subscribers;

class EmailSubscriber implements MessageSubscriber
{
    public function handleMessage($message)
    {
        // Handle email notification
    }
}

$messageMediator = new MessageMediator();
$messagePublisher = new MessagePublisher($messageMediator);

$emailSubscriber = new EmailSubscriber();
$messageMediator->subscribe($emailSubscriber);


///Mediator pattern se koristi kada imate složene interakcije
///  između objekata i želite da izbegnete povezivanje objekata direktno međusobno,
///  što može dovesti do velikog broja zavisnosti između njih i otežati održavanje koda.
///  U Laravelu, Mediator pattern se može koristiti za upravljanje složenim interakcijama
///  između različitih delova aplikacije, na primer u oblastima kao što su obaveštenja,
///  sistem za slanje poruka, moduli koji se koriste u više delova aplikacije itd.
///
/// Takođe, Mediator pattern se može koristiti kada imate više objekata koji se moraju
///  koordinirati da bi se izvršio određeni zadatak. Na primer, kada se objekti koriste
///  za slanje poruka, mogu postojati različite vrste poruka (SMS, e-pošta, obaveštenje
///  o aplikaciji itd.) i svaka vrsta poruke zahteva drugačiji set operacija za pripremu i slanje poruke.
///  U ovom slučaju, Mediator pattern se može koristiti za koordinaciju različitih objekata
///  koji su zaduženi za pripremu i slanje različitih vrsta poruka.