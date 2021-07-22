<?php

namespace SquareMvc\Foundation;

use SquareMvc\Foundation\Router\Router;

class App
{
    protected Router $router;

    /**
     * App constructor.
     * Init components (BDD, routes, sessions, PHP dotenv...)
     */
    public function __construct()
    {
        $this->initDotEnv();

        $this->router = new Router(require ROOT . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR .'routes.php');

        //var_dump($this->router);

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
        $this->router->getInstance();
    }
}