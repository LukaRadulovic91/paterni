<?php

///Composite design pattern se koristi kada želite da tretirate
///  skup objekata i pojedinačne instance tog skupa uniformno.
///  To znači da je cilj da se klijentu omogući da manipuliše sa
///  složenim objektima na isti način kao i sa pojedinačnim objektima.
///  U ovom šablonu, objekti su organizovani u hijerarhijsku strukturu u obliku stabla.
///  Koren stabla predstavlja složeni objekat, dok listovi predstavljaju pojedinačne objekte.
///  Kada se primeni Composite design pattern, klijenti ne moraju da brinu o tipu
///  objekta sa kojim rade, već se mogu fokusirati samo na operacije koje žele da izvrše.
//
//Composite design pattern se najčešće koristi u situacijama gde imamo drvo hijerarhije objekata,
// kao što je na primer kod grafičkog korisničkog interfejsa, gde imamo skup elemenata
// koji mogu biti organizovani u grupe i podgrupe.
//
//U Laravelu, Composite design pattern se može primeniti u situacijama kada
// želimo da kreiramo hijerarhijsku strukturu objekata, na primer kada želimo
// da organizujemo različite delove web aplikacije u obliku modula ili kada želimo
// da grupišemo slične operacije koje se primenjuju na različite modele u jednu apstraktnu klasu.

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface MenuComponent
{
    public function render();
}

class MenuItem implements MenuComponent
{
    private $title;
    private $url;

    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    public function render()
    {
        return "<li><a href='{$this->url}'>{$this->title}</a></li>";
    }
}

class Menu implements MenuComponent
{
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add(MenuComponent $component)
    {
        $this->items[] = $component;
    }

    public function render()
    {
        $menu = "<ul>";
        foreach ($this->items as $item) {
            $menu .= $item->render();
        }
        $menu .= "</ul>";
        return $menu;
    }
}

class CompositeMenuController extends Controller
{
    public function index()
    {
        $menu = new Menu();
        $menu->add(new MenuItem("Home", "/"));
        $submenu = new Menu();
        $submenu->add(new MenuItem("About Us", "/about-us"));
        $submenu->add(new MenuItem("Contact Us", "/contact-us"));
        $menu->add($submenu);
        $menu->add(new MenuItem("Blog", "/blog"));
        return $menu->render();
    }
}


