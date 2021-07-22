<?php

namespace SquareMvc\Foundation;

class App
{



    /**
     * App constructor.
     * Init components (BDD, routes, sessions, PHP dotenv...)
     */
    public function __construct()
    {
        $this->initDotEnv();

    }

    protected function initDotEnv():void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);

        $dotenv->safeLoad();
    }

    /**
     * Render
     */
    public function render(): void
    {
        echo 'Hello World';
    }
}