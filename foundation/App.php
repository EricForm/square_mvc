<?php

namespace SquareMvc\Foundation;

use Exception;
use JetBrains\PhpStorm\Pure;
use Illuminate\Database\Capsule\Manager as Capsule;
use SquareMvc\Foundation\Exceptions\HttpException;
use SquareMvc\Foundation\Router\Router;
use Symfony\Component\Routing\Generator\UrlGenerator;

class App
{
    protected Router $router;

    /**
     * App constructor.
     * Init components (BDD, routes, sessions, PHP dotenv...)
     * @throws Exception
     */
    public function __construct()
    {
        $this->initDotEnv();

        if(Config::get('app.env') === 'production') {
            $this->initProductionExceptionHandler();
        }

        $this->initSession();

        $this->initDatabase();

        $this->router = new Router(require ROOT . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR .'routes.php');
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
     * @throws Exception
     */
    protected function initSession(): void
    {
        Session::init();

        Session::add('_token', Session::get('_token') ?? $this->generateCsrfToken());
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function generateCsrfToken(): string
    {
        $length = Config::get('hashing.csrf_token_length');
        return bin2hex(random_bytes($length));
    }

    protected function initDatabase(): void
    {
        date_default_timezone_set('Europe/Paris');
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver'   => Config::get('database.driver'),
            'host'     => Config::get('database.host'),
            'database' => Config::get('database.name'),
            'username' => Config::get('database.username'),
            'password' => Config::get('database.password'),
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

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