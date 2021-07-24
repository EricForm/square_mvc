<?php

namespace SquareMvc\Foundation;

use JetBrains\PhpStorm\Pure;
use SquareMvc\Foundation\Exceptions\HttpException;
use SquareMvc\Foundation\Router\Router;
use Symfony\Component\Routing\Generator\UrlGenerator;

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

        if(Config::get('app.env') === 'production') {
            $this->initProductionExceptionHandler();
        }

        $this->initSession();

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

    protected function initSession(): void
    {
        Session::init();
    }

    /**
     * Render
     */
    public function render(): void
    {
        $this->router->getInstance();

        Session::resetFlash();
    }

    /**
     * @return UrlGenerator
     */
    #[Pure]
    public function getGenerator(): UrlGenerator
    {
        return $this->router->getGenerator();
    }
}