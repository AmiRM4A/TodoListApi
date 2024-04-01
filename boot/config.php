<?php

define('PROJ_DIR', dirname(__FILE__, 2));

# Database
define('DB_TYPE', $_ENV['DB_TYPE']);
define('DB_HOST', $_ENV['HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_PORT', $_ENV['DB_PORT']);
define('MEDOO_LOG', $_ENV['MEDOO_LOG']);