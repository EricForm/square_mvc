<?php

namespace App\Controllers;

use Faker\Factory;
use SquareMvc\Foundation\AbstractController;
use SquareMvc\Foundation\View;

class BaseController extends AbstractController
{
    public function index(): void
    {
        $faker = Factory::create();

        View::render('index', [
            'city' => $faker->city,
        ]);
    }
}