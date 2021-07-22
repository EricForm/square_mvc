<?php

// with php 7
// declare(strict_types = 1);

define('ROOT', str_replace(DIRECTORY_SEPARATOR.'public', '', __DIR__));

require_once ROOT . DIRECTORY_SEPARATOR .'vendor'. DIRECTORY_SEPARATOR . 'autoload.php';

$app = new SquareMvc\Foundation\App();

$app->render();