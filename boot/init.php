<?php

# Include required files

require '../vendor/autoload.php';
require './config.php';
require './autoloader.php';
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/helpers.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/Security.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/Str.php');

# Loading dotenv variables
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');

# Routing 