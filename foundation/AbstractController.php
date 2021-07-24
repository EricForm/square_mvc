<?php


namespace SquareMvc\Foundation;


use JetBrains\PhpStorm\NoReturn;
use SquareMvc\Foundation\Router\Router;


abstract class AbstractController
{
    /**
     * @param string $name
     * @param array $data
     */
    #[NoReturn] /* https://blog.jetbrains.com/phpstorm/2020/10/phpstorm-2020-3-eap-4/ */
    protected function redirect(string $name, array $data = []): void
    {
        header(sprintf('Location: %s', Router::get($name, $data)));
        die;
    }
}