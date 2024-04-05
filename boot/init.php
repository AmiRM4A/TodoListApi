<?php

use App\Router\Router;

# Include required files
require '../vendor/autoload.php';
require './autoloader.php';

# Loading dotenv variables
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__, 1) . '/.env');

require './config.php';
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/helpers.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/Security.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/Str.php');

# Routes
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Router/Routes/api.php');

# Routing
Router::dispatch();