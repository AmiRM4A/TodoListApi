<?php

# Main
define('PROJ_DIR', dirname(__FILE__, 2));
define('DEV_MODE', $_ENV['DEV_MODE']);

# | E_ERROR = 1 | E_WARNING = 2 | E_PARSE = 4 | E_NOTICE = 8 | E_ALL = 32767 |
# More => https://www.php.net/manual/en/errorfunc.constants.php
error_reporting($_ENV['ERROR_MODE']);

date_default_timezone_set('Asia/Tehran');

# Database
define('DB_TYPE', $_ENV['DB_TYPE']);
define('DB_HOST', $_ENV['HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_PORT', $_ENV['DB_PORT']);
define('MEDOO_LOG', $_ENV['MEDOO_LOG']);

# Token
define('REM_TOKEN_EXP_TIME', $_ENV['REM_TOKEN_EXP_TIME']);
define('TOKEN_EXP_TIME', $_ENV['TOKEN_EXP_TIME']);