<?php


namespace SquareMvc\Foundation\Router;

use SquareMvc\Foundation\AbstractController;
use Symfony\Component\Routing\Route as SymfonyRoute;

class Route
{
    public const HTTP_METHODS = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * @param string $httpMethod
     * @param array $arguments
     * @return SymfonyRoute
     */
    public static function __callStatic(string $httpMethod, array $arguments): SymfonyRoute
    {
        if (!in_array(strtoupper($httpMethod), static::HTTP_METHODS)) {
            throw new \BadMethodCallException(
                sprintf('HTTP method not available (%s)', $httpMethod)
            );
        }
        [$uri, $action] = $arguments;

        return static::make($uri, $action, $httpMethod);
    }

    /**
     * @param string $uri
     * @param array $action
     * @param string $httpMethod
     * @return SymfonyRoute
     */
    protected static function make(string $uri, array $action, string $httpMethod): SymfonyRoute
    {
        [$controller, $method] = $action;
        if (!static::checkIfActionExists($controller, $method)) {
            throw new \InvalidArgumentException(
                sprintf('Action does not exist (%s)', implode(', ', $action))
            );
        }

        return new SymfonyRoute(
            $uri,
            [
                '_controller' => $controller,
                '_method' => $method
            ],
            methods: [$httpMethod],
            options: [
                'utf8' => true,
            ]
        );
    }

    /**
     * @param string $controller
     * @param string $method
     * @return bool
     */
    protected static function checkIfActionExists(string $controller, string $method): bool
    {
        return class_exists($controller) && is_subclass_of($controller, AbstractController::class) && method_exists($controller, $method);
    }
}