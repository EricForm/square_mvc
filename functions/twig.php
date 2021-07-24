<?php

use JetBrains\PhpStorm\Pure;
use SquareMvc\Foundation\Authentication;
use SquareMvc\Foundation\Router\Router;
use SquareMvc\Foundation\Session;
use SquareMvc\Foundation\View;

/* Authentication */

if (!function_exists('auth')) {
    function auth(): Authentication
    {
        return new Authentication();
    }
}

/* Router */

if (!function_exists('route')) {
    function route(string $name, array $data = []): string
    {
        return Router::get($name, $data);
    }
}

/* Session message */

if (!function_exists('errors')) {
    function errors(?string $field = null): ?array
    {
        $errors = Session::getFlash(Session::ERRORS);
        if ($field) {
            return $errors[$field] ?? null;
        }
        return $errors;
    }
}

if (!function_exists('status')) {
    function status(): ?string
    {
        return Session::getFlash(Session::STATUS);
    }
}

/* CSRF */

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return View::csrfField();
    }
}

/* Method */

if (!function_exists('method')) {
    #[Pure]
    function method(string $httpMethod): string
    {
        return View::method($httpMethod);
    }
}

/* Old value */

if (!function_exists('old')) {
    function old(string $key, mixed $default = null): mixed
    {
        return View::old($key, $default);
    }
}