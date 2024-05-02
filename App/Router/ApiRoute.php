<?php

namespace App\Router;

/**
 * ApiRoute class
 *
 * The ApiRoute class is a subclass of the Route class and is designed to handle API routes
 * in a web application. It automatically applies the CORS (Cross-Origin Resource Sharing)
 * middleware to all API routes.
 */
class ApiRoute extends Route {
	/**
	 * Route constructor.
	 *
	 * @param string $route The route path.
	 * @param array|string $method The HTTP methods allowed for this route.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 * @param array|string $middleware An array or string of middleware classes/functions to be executed before the route action.
	 */
	public function __construct(string $route, array|string $method, callable|array|string $action, array|string $middleware = []) {
		// Call the parent constructor with the provided parameters
		parent::__construct($route, $method, $action, $middleware);
		
		// Apply the CORS middleware to the route
		$this->middleware(\App\Middlewares\CORS::class);
	}
	
	/**
	 * Add the Auth middleware to the middleware stack.
	 *
	 * @param bool $auth Whether to add the Auth middleware or not. Default is true.
	 * @return void
	 */
	public function auth(bool $auth = true): void {
		if ($auth) {
			$this->middleware[] = \App\Middlewares\Auth::class;
		}
	}
}