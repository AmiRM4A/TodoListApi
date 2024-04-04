<?php

use App\Router\Route;

# API Routes Would Be Here...

## Route ##
# Declaring Route Names:
# Static: tasks (domain.com/tasks)
# Dynamic(Slug): tasks/{task_id} (domain.com/tasks/2(task_id))
# Custom regex for each route slug by using ->where('param_name', 'regex'):
# ----------------------------------------------------------------
## Method ##
# String => 'Controller@Method'
# Array => ['Controller' , 'Method']
# Callable => Just pass an anonymous function
# ----------------------------------------------------------------
## Action ##
# You can generate response by response class. returning or sending response directly (with ->send method of response class) is available
Route::new('/', ['get', 'post'], function () {
	return 'Welcome to Api';
});