<?php


namespace SquareMvc\Foundation\Exceptions;


class HttpException extends \Exception
{
    public static function render(int $httpCode = 404, string $message = 'Page not found'): void
    {
        http_response_code($httpCode);
        echo "<h1>Error $httpCode : $message</h1>";
        die;
    }
}