<?php

/// U Laravel-u, Facade design pattern se koristi za obezbeđivanje
///  jednostavnog i intuitivnog interfejsa ka složenim podsklopovima Laravel aplikacije,
///  kao što su servisi, klasa za upravljanje baze podataka, cache i druge klase.
//
//Ova šablona se koristi kada se želi sakriti kompleksnost kompleksnih sistema
// ili kada se želi pružiti jednostavan interfejs za rad sa određenim delom sistema.
// Facade se ponaša kao "lažna" klasa koja obavija složen sistem i pruža jednostavan interfejs za rad sa njim.
//
//Jedan od najpoznatijih primera upotrebe Facade design patterna u Laravelu je
// DB facade koja se koristi za upravljanje bazom podataka. Njegova jednostavna sintaksa
// omogućava jednostavan pristup bazama podataka bez potrebe za pisanjem SQL upita.

class ComplexLogic
{
    public function step1()
    {
        // neki složeni korak
    }

    public function step2()
    {
        // još jedan složeni korak
    }

    public function step3()
    {
        // i tako dalje...
    }
}


class Facade
{
    protected $complexLogic;

    public function __construct(ComplexLogic $complexLogic)
    {
        $this->complexLogic = $complexLogic;
    }

    public function doSomething()
    {
        $this->complexLogic->step1();
        $this->complexLogic->step2();
        // neke druge akcije koje treba izvršiti
    }
}


class SomeController extends Controller
{
    public function index()
    {
        $complexLogic = new ComplexLogic();
        $facade = new Facade($complexLogic);
        $facade->doSomething();
    }
}
