<?php
// TODO: It must be included as a middleware (before method checking)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: Authorization, Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	exit(http_response_code(200));
}

# Include required files
require '../vendor/autoload.php';
require './autoloader.php';

# Load dotenv variables
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__, 1) . '/.env');

require './config.php';
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/helpers.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/Security.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Helpers/Str.php');

# Include route definitions
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Router/Routes/api.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Router/Routes/task.php');
require PROJ_DIR . str_replace('/', DIRECTORY_SEPARATOR, '/App/Router/Routes/user.php');

# Dispatch routing
App\Router\Router::dispatch();