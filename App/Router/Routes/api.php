<?php

use App\Router\Route;

# API Routes Would Be Here...

## Route ##
# Declaring Route Names:
# Static: tasks (domain.com/tasks)
## Method ##
# String => 'Controller@Method'
# Array => ['Controller' , 'Method']
# Callable => Just pass an anonymous function

Route::new('/', ['get', 'post'], function () {
	echo 'Welcome to API';
});