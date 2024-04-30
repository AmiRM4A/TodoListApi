<?php

use App\Router\ApiRoute;

/**
 * Define API Routes
 *
 * This section declares routes for the API endpoints.
 */

## Route ##
# Define Route Names:
# Static: Use just the route name (e.g., domain.com/tasks)
# Dynamic (Slug): Specify dynamic segments using curly braces (e.g., domain.com/tasks/{task_id})
# Customize regex for dynamic segments with ->where('param_name', 'regex'):
# Middleware list for the route with ->middleware(String or Array of Middlewares)
# ----------------------------------------------------------------
## Method ##
# Specify the method to handle the route:
# String: 'Controller@Method'
# Array: ['Controller' , 'Method']
# Callable: Use an anonymous function directly
# ----------------------------------------------------------------
## Action ##
# Responses can be generated using the response class. You can either return the response or send it directly using the ->send method of the response class.

ApiRoute::new('/', ['get', 'post'], function () {
	return response()->message('Welcome to the API')->json();
});