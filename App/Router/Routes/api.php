<?php

use App\Router\Route;

# API Routes Would Be Here...

# Avalable Route Adding Methods:
# String => 'Controller@Method'
# Array => ['Controller' , 'Method']
# Callable => Just pass an anonymous function

Route::add('/', ['get', 'post'], function () {
	echo 'Welcome to API';
});