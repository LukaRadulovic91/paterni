<?php

/// Flyweight dizajn patern se koristi u Laravelu kada se radi
///  sa velikim brojem objekata koji imaju slične karakteristike.
///  Ovaj patern omogućava efikasniju upotrebu memorije tako što
///  deli zajedničke podatke između više objekata umesto da svaki
///  objekat čuva sopstvene kopije tih podataka.
//
//Na primer, može se koristiti za čuvanje podataka o bojama koje se
// koriste na web stranici, gde svaka boja ima svoj identifikator,
// ali se sama boja čuva samo jednom. Takođe, može se koristiti za
// optimizaciju upotrebe memorije u slučajevima kada se radi sa
// velikim brojem objekata koji imaju slične karakteristike.
//
//U Laravelu, Flyweight patern se najčešće koristi u kombinaciji sa
// Factory patternom kako bi se obezbedilo efikasnije kreiranje i
// upravljanje objektima sa zajedničkim podacima.
//
//Napredan primer implementacije Flyweight patterna u Laravelu može
// uključivati upotrebu ovog paterna za upravljanje velikim brojem
// slika koje se koriste na web stranici. Umesto da se svaka slika
// učitava i čuva u memoriji kao zaseban objekat, Flyweight patern
// omogućava deljenje zajedničkih podataka (npr. putanja do slike)
// između više objekata, što može dovesti do znatne uštede u korišćenju memorije.

interface ColorFlyweight
{
    public function getRGBValue(): string;
}

class ConcreteColorFlyweight implements ColorFlyweight
{
    private $red;
    private $green;
    private $blue;

    public function __construct($red, $green, $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function getRGBValue(): string
    {
        return "rgb({$this->red},{$this->green},{$this->blue})";
    }
}


class ColorFactory
{
    private $colors = [];

    public function getColor($red, $green, $blue): ColorFlyweight
    {
        $key = "{$red}-{$green}-{$blue}";

        if (!isset($this->colors[$key])) {
            $this->colors[$key] = new ConcreteColorFlyweight($red, $green, $blue);
        }

        return $this->colors[$key];
    }
}


class HomeController extends Controller
{
    private $colorFactory;

    public function __construct(ColorFactory $colorFactory)
    {
        $this->colorFactory = $colorFactory;
    }

    public function index()
    {
        $color1 = $this->colorFactory->getColor(255, 0, 0);
        $color2 = $this->colorFactory->getColor(255, 255, 0);
        $color3 = $this->colorFactory->getColor(0, 255, 0);
        $color4 = $this->colorFactory->getColor(0, 255, 255);
        $color5 = $this->colorFactory->getColor(0, 0, 255);
        $color6 = $this->colorFactory->getColor(255, 0, 255);

        return view('home', [$color1, $color2, $color3, $color4, $color5, $color6]);
    }
}

