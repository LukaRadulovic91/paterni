<?php

///Factory Method dizajn patern se koristi u Laravel-u kada se želi
///  kreirati objekat koji zavisi od trenutnog konteksta aplikacije.
//Na primer, kada je potrebno kreirati objekat koji je specifičan za
// određeni tip korisnika. Ovo se može postići pomoću Factory Method
// paterna tako što ćemo kreirati apstraktnu klasu koja definiše interfejs
// za kreiranje objekata, a zatim ćemo kreirati konkretne implementacije
// ove klase koje će kreirati objekte koji su specifični za određene tipove korisnika.
//Ovaj patern nam takođe omogućava da se izbegne upotreba if/else naredbi,
// što dovodi do lakšeg održavanja koda.
//Na primer, ako imamo aplikaciju koja pruža različite usluge za različite
// korisničke uloge, možemo koristiti Factory Method patern za kreiranje
// objekata koji će pružiti odgovarajuće usluge u zavisnosti od uloge korisnika.

interface ProductFactory {
    public function createProduct($type);
}


class ConcreteProductFactory implements ProductFactory {
    public function createProduct($type) {
        if ($type == 'TypeA') {
            return new TypeAProduct();
        } elseif ($type == 'TypeB') {
            return new TypeBProduct();
        } else {
            throw new Exception("Invalid product type.");
        }
    }
}


abstract class Product {
    protected $name;
    protected $price;
    // ...
}

class TypeAProduct extends Product {
    public function __construct() {
        $this->name = 'Type A';
        $this->price = 100;
        // ...
    }
}

class TypeBProduct extends Product {
    public function __construct() {
        $this->name = 'Type B';
        $this->price = 200;
        // ...
    }
}


class ProductController extends Controller {
    protected $factory;

    public function __construct(ConcreteProductFactory $factory) {
        $this->factory = $factory;
    }

    public function createProduct($type) {
        $product = $this->factory->createProduct($type);
        // ...
    }
}
