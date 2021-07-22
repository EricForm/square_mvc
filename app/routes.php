<?php

use App\Controllers\BaseController;
use SquareMvc\Foundation\Router\Route;

return [
    'index' => Route::get('/', [BaseController::class, 'index'])
];
