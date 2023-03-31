<?php

// Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'status'];
}

// Iterator
namespace App\Iterators;

use App\Models\Project;

class ProjectIterator implements \Iterator
{
    private $projects;
    private $position = 0;

    public function __construct(array $projects)
    {
        $this->projects = $projects;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->projects[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->projects[$this->position]);
    }
}

// Service
namespace App\Services;

use App\Iterators\ProjectIterator;
use App\Models\Project;

class ProjectService
{
    public function getProjectsByUser($userId)
    {
        $projects = Project::where('user_id', $userId)->get()->toArray();
        $iterator = new ProjectIterator($projects);

        while ($iterator->valid()) {
            $project = $iterator->current();
            echo $project['name'] . ': ' . $project['description'] . ' - ' . $project['status'] . '<br>';
            $iterator->next();
        }
    }
}

// COntroller
namespace App\Http\Controllers;

use App\Services\ProjectService;

class ProjectController extends Controller
{
    public function index($userId)
    {
        $projectService = new ProjectService();
        $projectService->getProjectsByUser($userId);
    }
}

///////////////////
///             ///
/// WHEN TO USE ///
///             ///
///////////////////
///  Iterator design pattern se koristi u Laravelu kada želite provesti iteraciju
///  (prolazak kroz) nekog skupa podataka. Ovaj obrazac je koristan kada imate složene
///  podatke koje treba prikazati u različitim formatima, a ne želite vezati vaš kod za specifičan tip podataka.
//
//    Evo nekoliko situacija u kojima biste mogli koristiti Iterator design pattern u Laravelu:
//
//    1. Kada radite s velikim skupom podataka: Ako radite s velikim skupom podataka,
// ne želite odjednom učitati sve podatke u memoriju jer to može dovesti do problema s performansama.
// Iterator design pattern omogućuje vam da koristite "lijeno učitavanje" (lazy loading)
// kako biste postupno učitali podatke u memoriju tijekom iteracije.
//
//    2. Kada želite različite načine prikaza istih podataka: Iterator design pattern omogućuje
// vam da odvojite prikaz podataka od samih podataka. Možete stvoriti različite iteratore za prikaz
// istih podataka u različitim formatima, na primjer, tablicama, grafovima ili PDF datotekama.
//
//    3. Kada želite iterirati kroz složene podatke: Iterator design pattern omogućuje
// vam da iterirate kroz složene podatke, poput višestrukih razina ugniježđenih objekata ili
// povezanih podataka između više tablica u bazi podataka.
//
//    Primjer upotrebe Iteratora u Laravelu može biti ako imate složene podatke koji su
// spremljeni u bazu podataka. Možete stvoriti iterator koji će iterirati kroz sve zapise
// u bazi podataka i prikazati ih u određenom formatu, kao što je tablica ili grafikon.
// Također možete stvoriti iterator koji će iterirati kroz samo određene zapise u bazi podataka,
// na primjer, samo one koji su stariji od određenog datuma ili samo one koji ispunjavaju određene uvjete.