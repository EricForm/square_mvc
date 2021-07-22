<?php

namespace SquareMvc\Foundation;

class App
{

    /**
     * App constructor.
     * Initialisation des composants (BDD, routes, sessions, PHP dotenv...)
     */
    public function __construct()
    {

    }

    /**
     * Render
     */
    public function render(): void
    {
        echo 'Hello World';
    }
}