<?php


namespace SquareMvc\Foundation\Exceptions;


use JetBrains\PhpStorm\NoReturn;
use SquareMvc\Foundation\View;

class HttpException extends \Exception
{
    /**
     * @param int $httpCode
     * @param string $message
     */
    #[NoReturn] /* https://blog.jetbrains.com/phpstorm/2020/10/phpstorm-2020-3-eap-4/ */
    public static function render(int $httpCode = 404, string $message = 'Page not found'): void
    {
        http_response_code($httpCode);
        View::render('errors.default', [
            'httpCode' => $httpCode,
            'message' => $message,
        ]);
        die;
    }
}