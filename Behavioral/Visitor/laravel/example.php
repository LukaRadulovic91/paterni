<?php

///Visitor design pattern se u Laravelu može koristiti u situacijama
///  kada se radi sa kompleksnom hijerarhijom objekata i kada postoji
///  potreba da se na svakom od tih objekata izvrši neka operacija bez da se
///  mijenja klasa samog objekta. Ovaj pattern se takođe može koristiti kada želimo da
///  izbjegnemo korištenje instance of operatora ili kada želimo da odvojimo operacije od objekata.
//
//Na primjer, ako imamo kompleksnu hijerarhiju objekata koji predstavljaju
// strukturu web stranice, možemo koristiti Visitor pattern da bismo
// izvršili operaciju koja analizira strukturu i identifikuje određene elemente.
// Takođe, možemo koristiti Visitor pattern da bismo izvršili operaciju koja
// mijenja stilove web stranice, bez da mijenjamo samu strukturu web stranice.
//
//U Laravelu, Visitor pattern se često koristi u kombinaciji sa Eloquent ORM-om,
// gdje se omogućuje da se na objekte baze podataka primijeni neka operacija,
// bez da se kreira posebna metoda za svaku tablicu u bazi podataka.

interface Visitable
{
    public function accept(Visitor $visitor);
}

class Post implements Visitable
{
    public function accept(Visitor $visitor)
    {
        $visitor->visitPost($this);
    }
}

class Comment implements Visitable
{
    public function accept(Visitor $visitor)
    {
        $visitor->visitComment($this);
    }
}


interface Visitor
{
    public function visitPost(Post $post);

    public function visitComment(Comment $comment);
}

class UserActionVisitor implements Visitor
{
    public function visitPost(Post $post)
    {
        // primenjujemo neku akciju na Post model
        // na primer, dodajemo like
    }

    public function visitComment(Comment $comment)
    {
        // primenjujemo neku akciju na Comment model
        // na primer, dodajemo report
    }
}

class ModeratorActionVisitor implements Visitor
{
    public function visitPost(Post $post)
    {
        // primenjujemo neku drugu akciju na Post model
        // na primer, brišemo post
    }

    public function visitComment(Comment $comment)
    {
        // primenjujemo neku drugu akciju na Comment model
        // na primer, brišemo comment
    }
}


$post = new Post();
$comment = new Comment();

$user = new User();
$moderator = new Moderator();

$userActionVisitor = new UserActionVisitor();
$moderatorActionVisitor = new ModeratorActionVisitor();

// korisnik primenjuje akciju na Post model
$post->accept($userActionVisitor);

// korisnik primenjuje akciju na Comment model
$comment->accept($userActionVisitor);

// moderator primenjuje akciju na Post model
$post->accept($moderatorActionVisitor);

// moderator primenjuje akciju na Comment model
$comment->accept($moderatorActionVisitor);
