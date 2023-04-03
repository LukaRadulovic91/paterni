<?php

/// Singleton design pattern se koristi u Laravelu kada želimo
///  da obezbedimo da se određena klasa instancira samo jednom
///  i da ta instanca bude dostupna na globalnom nivou.
///  To se često koristi kada imamo objekte koji su resursno skupi za kreiranje,
///  poput baze podataka ili spoljnih API-ja, a želimo da imamo samo
///  jednu instancu tih objekata tokom životnog ciklusa aplikacije.
//
//U Laravelu, primeri klasa koje koriste Singleton dizajn uzorak uključuju
// klasu DB koja pruža globalni pristup bazi podataka, klasu Cache koja pruža
// globalni pristup kešu i klasu Log koja pruža globalni pristup logovanju.

/// Recimo da imamo aplikaciju koja zahteva pristup bazi podataka na više mesta.
///  Možemo napraviti Singleton klasu koja će se koristiti za pristup bazi podataka
///  i koja će se instancirati samo jednom tokom životnog ciklusa aplikacije.
///  To će nam omogućiti da imamo samo jednu vezu sa bazom podataka i smanjimo broj konekcija.


namespace App\Database;

class DatabaseConnection
{
    protected static $instance;

    protected $connection;

    protected function __construct()
    {
        $this->connection = new \PDO('mysql:host=localhost;dbname=mydatabase', 'username', 'password');
    }

    public static function getInstance()
    {
        if (! static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}


namespace App\Http\Controllers;

use App\Database\DatabaseConnection;

class UserController extends Controller
{
    public function index()
    {
        $db = DatabaseConnection::getInstance()->getConnection();

        $users = $db->query('SELECT * FROM users')->fetchAll();

        return view('users.index', compact('users'));
    }
}
