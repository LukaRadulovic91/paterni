<?php

///Pattern "Prototype" se koristi kada je potrebno kreirati
///  objekte koji su skupi za kreiranje ili kada je potrebno
///  kreirati objekte sa složenim strukturama, a time je olakšan
///  njihov proces kreiranja. Ovaj patern se takođe koristi
///  kada je potrebno izbeći "zaključavanje" objekata u vreme
///  kompilacije i omogućiti im da budu konfigurisani u vreme izvršavanja.
//
//U Laravelu, ovaj patern se može primeniti u različitim situacijama, na primer:
//
// 1.   Kreiranje složenih objekata sa mnoštvom veza sa drugim objektima,
// što može olakšati proces kreiranja.
// 2.   Kreiranje više instanci istog objekta sa različitim vrednostima,
// kao što su različite konfiguracije za različite delove aplikacije.
// 3.   Optimizacija performansi tako što se sprečava ponovno kreiranje
// objekata sa skupim procesom inicijalizacije.
//
//U ovim situacijama, primena "Prototype" paterna omogućava efikasnije
// korišćenje resursa i povećava fleksibilnost u procesu kreiranja objekata.
//
//Napredan primer primene ovog paterna u Laravelu bi bio u okviru kreiranja
// složenih objekata u okviru aplikacije. Na primer, u razvoju veb prodavnice,
// "Prototype" patern se može primeniti za kreiranje objekata "Proizvod" sa
// velikim brojem veza sa drugim objektima, kao što su "Kategorije", "Slike proizvoda" itd.
// Ovaj patern bi omogućio lakše kreiranje ovih objekata i poboljšao efikasnost procesa.

interface ProjectPrototype {
    public function clone(): ProjectPrototype;
}


abstract class Project implements ProjectPrototype {
    protected $name;
    protected $description;
    protected $budget;
    protected $deadline;

    public function __construct(string $name, string $description, float $budget, Carbon $deadline) {
        $this->name = $name;
        $this->description = $description;
        $this->budget = $budget;
        $this->deadline = $deadline;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getBudget(): float {
        return $this->budget;
    }

    public function getDeadline(): Carbon {
        return $this->deadline;
    }

    public function clone(): ProjectPrototype {
        return clone $this;
    }

    abstract public function getType(): string;
}


class WebProject extends Project {
    public function getType(): string {
        return 'Web Project';
    }
}

class MobileProject extends Project {
    public function getType(): string {
        return 'Mobile Project';
    }
}

class DesktopProject extends Project {
    public function getType(): string {
        return 'Desktop Project';
    }
}


$webProject = new WebProject('Web Project 1', 'This is a web project', 5000, Carbon::now()->addMonths(3));
$newWebProject = $webProject->clone();
$newWebProject->setName('Web Project 2');
$newWebProject->setBudget(8000);
$newWebProject->setDeadline(Carbon::now()->addMonths(6));
