<?php

namespace SquareMvc\Foundation;

use SquareMvc\Foundation\Exceptions\HttpException;
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

        if(env('APP_ENV', 'production') === 'production') {
            $this->initProductionExceptionHandler();
        }

        $this->router = new Router(require ROOT . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR .'routes.php');

        //var_dump($this->router);

    }

    protected function initDotEnv():void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);

        $dotenv->safeLoad();
    }

    protected function initProductionExceptionHandler(): void
    {
        set_exception_handler(
            fn () => HttpException::render(500, 'Houston, we have a problem!')
        );
    }

    /**
     * Render
     */
    public function render(): void
    {
        $this->router->getInstance();
    }


}