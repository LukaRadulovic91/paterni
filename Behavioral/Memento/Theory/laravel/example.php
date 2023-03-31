<?php

///Pretpostavimo da imate aplikaciju koja omogućava korisnicima da
///  stvaraju i čuvaju nacrte blog postova. Svaki nacrt ima naslov,
///  sadržaj i status koji označava da li je objavljen ili ne.
///  Korisnici mogu da vrše izmene na nacrtima i da ih čuvaju kao nove verzije.
///  Međutim, takođe im je potrebna mogućnost da se vrate na prethodnu verziju
///  ako naprave grešku ili promene mišljenje o izmenama. U tom slučaju,
///  Memento dizajn obrazac se može koristiti za čuvanje i vraćanje stanja blog posta.


class BlogPostMemento
{
    protected $title;
    protected $content;
    protected $status;

    public function __construct($title, $content, $status)
    {
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getStatus()
    {
        return $this->status;
    }
}

class BlogPost
{
    protected $title;
    protected $content;
    protected $status;
    protected $mementos = [];

    public function __construct($title, $content, $status)
    {
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function save()
    {
        $this->mementos[] = new BlogPostMemento($this->title, $this->content, $this->status);
    }

    public function restore()
    {
        $memento = array_pop($this->mementos);

        $this->title = $memento->getTitle();
        $this->content = $memento->getContent();
        $this->status = $memento->getStatus();
    }
}

///////////////////
///             ///
/// WHEN TO USE ///
///             ///
///////////////////
/// Memento design pattern se koristi u Laravelu kada želite da implementirate
///  funkcionalnost poništavanja (undo) određene akcije.
///  To se obično dešava kada korisnik želi da vrati prethodno stanje aplikacije,
///  ili ako želite da omogućite neku vrstu istorije izvršenih akcija.
///  Takođe, Memento pattern se može koristiti kada treba da se omogući povratak
///  na prethodno stanje sistema nakon izvršavanja neke kritične operacije
///  koja bi mogla da izazove neželjene efekte na stanje aplikacije.
//
//Na primer, ako korisnik unosi podatke u formu za kreiranje novog objekta,
// možda će želeti da poništi tu akciju i vrati se na prethodno stanje,
// možda zbog greške ili želje da promeni neki unos. U tom slučaju,
// možete koristiti Memento pattern kako biste omogućili poništavanje
// akcije i vraćanje na prethodno stanje.
//
//Takođe, Memento pattern se može koristiti za implementaciju redo funkcionalnosti,
// koja omogućava korisniku da ponovo izvrši akciju koju je prethodno poništio.
