<?php


namespace SquareMvc\Foundation;


use Symfony\Component\Routing\Router;

abstract class AbstractController
{
    protected function redirect(string $name, array $data = []): void
    {
        // get n'existe pas encore pour le moment!
        header(sprintf('Location: %s', Router::get($name, $data)));
        die;
    }
}