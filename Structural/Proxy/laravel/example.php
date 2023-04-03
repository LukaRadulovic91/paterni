<?php

/// Proxy design pattern se koristi kada želimo da obezbedimo
///  kontrolu nad pristupom nekom objektu, ili kada je kreiranje
///  objekta skup proces pa ga želimo kreirati samo po potrebi.
///  Takođe, ovaj pattern može biti koristan kada želimo da
///  obavimo neke dodatne operacije pre ili posle poziva metoda na objektu.
//
//U Laravelu, Proxy design pattern se često koristi za lazy loading
// relacija između modela. Na primer, ako imamo model User koji ima
// relaciju ka modelu Post, možemo kreirati UserProxy klasu koja će
// biti odgovorna za pristup Post modelu. U ovom slučaju,
// UserProxy će se kreirati samo kada je to zaista potrebno,
// a ne pri svakom pozivu na User modelu.

interface PostProxyInterface
{
    public function getContent();
}

class PostProxy implements PostProxyInterface
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getContent()
    {
        return $this->post->content;
    }
}

class User
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getPostProxy()
    {
        return new PostProxy($this->posts()->first());
    }
}
