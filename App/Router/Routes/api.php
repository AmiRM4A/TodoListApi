<?php

use App\Router\ApiRoute;

/**
 * API Routes Definition
 *
 * This file is responsible for defining all the routes for the API endpoints.
 *
 * Route Definition Syntax:
 *		ApiRoute::new('route_pattern', ['http_methods'], $action, $middleware[Optional]);
 *   	- 'route_pattern' is the URL pattern for the route (e.g., '/', '/users/{id}')
 *   	- ['http_methods'] is an array of HTTP methods allowed for the route (e.g., ['GET', 'POST'])
 *   	- $action is the code to be executed when the route is matched, which can be:
 *     		- A string in the format 'Controller@method'
 *     		- An array in the format ['Controller', 'method']
 *     		- An anonymous function or callable
 *		- $middleware[Optional] is an optional parameter that specifies the middleware(s) to be applied to the route.
 *			- A string (for a single middleware) or an array of middleware.
 *
 * Additional Options:
 *   - Dynamic segments in route patterns can be specified using curly braces (e.g., '/users/{id}').
 *   - Regular expressions for dynamic segments can be customized using the ->where() method.
 *   - Middleware can be applied to routes using the ->middleware() method.
 *
 * Generating Responses:
 *   - Responses can be generated using the `response()` helper function.
 *   - The `response()` helper returns an instance of the Response class, which provides methods for setting the response content, headers, and status code.
 *   - Responses can be returned directly from the route action or sent using the `->send()` method.
 *
 * Example:
 * ApiRoute::new('/', ['GET', 'POST'], function () {
 *     return response()->message('Welcome to the API')->json()->middleware(\App\Middlewares\CORS::class);
 * });
 */

ApiRoute::new('/', ['get', 'post'], function () {
	return response()->message('Welcome to the API')->json();
});

ApiRoute::post('login', 'AuthController@handleLogin');
ApiRoute::post('log-out', 'AuthController@handleLogOut')->auth();
ApiRoute::post('me', 'MeController@getLoginData')->auth();