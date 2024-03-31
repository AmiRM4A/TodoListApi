<?php

use App\Router\Route;

# API Routes Would Be Here...

## Route ##
# Declaring Route Names:
# Static: tasks (domain.com/tasks)
# Dynamic(Slug): tasks/{task_id} (domain.com/tasks/2(task_id))
# Custom regex for each route slug by using ->where('param_name', 'regex'):
## Method ##
# String => 'Controller@Method'
# Array => ['Controller' , 'Method']
# Callable => Just pass an anonymous function

Route::new('/', ['get', 'post'], function () {
	echo 'Welcome to API';
});