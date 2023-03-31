<?php


namespace App\Mediator;

interface ChatMediatorInterface
{
    public function sendMessage(string $message, string $sender): void;

    public function addUser(User $user): void;
}


namespace App\Mediator;

class ChatRoom implements ChatMediatorInterface
{
    private $users = [];

    public function sendMessage(string $message, string $sender): void
    {
        foreach ($this->users as $user) {
            if ($user->getName() !== $sender) {
                $user->receiveMessage($message);
            }
        }
    }

    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }
}


namespace App\Mediator;

class User
{
    private $name;
    private $chatMediator;

    public function __construct(string $name, ChatMediatorInterface $chatMediator)
    {
        $this->name = $name;
        $this->chatMediator = $chatMediator;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function send(string $message): void
    {
        $this->chatMediator->sendMessage($message, $this->name);
    }

    public function receiveMessage(string $message): void
    {
        echo $this->name . ' received message: ' . $message . "\n";
    }
}


namespace App\Mediator;

$mediator = new ChatRoom();

$user1 = new User('Alice', $mediator);
$user2 = new User('Bob', $mediator);
$user3 = new User('Charlie', $mediator);

$mediator->addUser($user1);
$mediator->addUser($user2);
$mediator->addUser($user3);

$user1->send('Hello, everyone!');
$user2->send('Hi, Alice!');

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