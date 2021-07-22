<?php

namespace App\Controllers;

use Faker\Factory;
use SquareMvc\Foundation\AbstractController;

class BaseController extends AbstractController
{
    public function index(): void
    {
        $faker = Factory::create();

        echo "<h1>Laissez-moi devinez! Vous vivez à $faker->city?</h1>";
    }
}