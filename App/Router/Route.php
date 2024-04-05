<?php

namespace App\Router;

use App\Helpers\Str;

/**
 * Class Route
 *
 * Represents a route in the application router.
 */
class Route {
	/**
	 * The registered routes.
	 *
	 * @var array An array containing all registered routes.
	 */
	private static array $routes = [];
	
	/**
	 * The route path.
	 *
	 * @var string The route path.
	 */
	protected string $route;
	
	/**
	 * The HTTP methods allowed for this route.
	 *
	 * @var array|string The HTTP methods allowed for this route.
	 */
	protected array|string $method;
	
	/**
	 * The action to be performed when the route is matched.
	 *
	 * @var callable|array|string The action to be performed when the route is matched.
	 */
	protected mixed $action;
	
	/**
	 * The route parameter constraints.
	 *
	 * @var array The route parameter constraints.
	 */
	protected array $where = [];
	
	/**
	 * Route constructor.
	 *
	 * @param string $route The route path.
	 * @param array|string $method The HTTP methods allowed for this route.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 */
	public function __construct(string $route, array|string $method, callable|array|string $action) {
		$this->route = $route;
		$this->method = (array) Str::toUpperCase($method);
		$this->action = $action;
		static::add($this);
	}
	
	/**
	 * Create a new route instance.
	 *
	 * @param string $route The route path.
	 * @param array|string $method The HTTP methods allowed for this route.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 *
	 * @return static The newly created route instance.
	 */
	public static function new(string $route, array|string $method, callable|array|string $action): static {
		return new static(...func_get_args());
	}
	
	/**
	 * Add a route to the registered routes.
	 *
	 * @param Route $route The route to add.
	 *
	 * @return void
	 */
	private static function add(Route $route): void {
		static::$routes[$route->route] = $route;
	}
	
	/**
	 * Add parameter constraints to the route.
	 *
	 * @param string $param The parameter name.
	 * @param string $regex The regular expression constraint.
	 *
	 * @return static The current Route instance.
	 */
	public function where(string $param, string $regex): static {
		$this->where[$param] = $regex;
		return $this;
	}
	
	/**
	 * Define a GET route.
	 *
	 * @param string $route The route path.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 *
	 * @return static The newly created GET route instance.
	 */
	public static function get(string $route, callable|array|string $action): static {
		return static::new($route, 'GET', $action);
	}
	
	/**
	 * Define a POST route.
	 *
	 * @param string $route The route path.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 *
	 * @return static The newly created POST route instance.
	 */
	public static function post(string $route, callable|array|string $action): static {
		return static::new($route, 'POST', $action);
	}
	
	/**
	 * Define a PUT route.
	 *
	 * @param string $route The route path.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 *
	 * @return static The newly created PUT route instance.
	 */
	public static function put(string $route, callable|array|string $action): static {
		return static::new($route, 'PUT', $action);
	}
	
	/**
	 * Define a DELETE route.
	 *
	 * @param string $route The route path.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 *
	 * @return static The newly created DELETE route instance.
	 */
	public static function delete(string $route, callable|array|string $action): static {
		return static::new($route, 'DELETE', $action);
	}
	
	/**
	 * Define a PATCH route.
	 *
	 * @param string $route The route path.
	 * @param callable|array|string $action The action to be performed when the route is matched.
	 *
	 * @return static The newly created PATCH route instance.
	 */
	public static function patch(string $route, callable|array|string $action): static {
		return static::new($route, 'PATCH', $action);
	}
	
	/**
	 * Get all registered routes.
	 *
	 * @return array An array containing all registered routes.
	 */
	public static function getRoutes(): array {
		return static::$routes;
	}
	
	/**
	 * Get the HTTP methods allowed for this route.
	 *
	 * @return array|string The HTTP methods allowed for this route.
	 */
	public function method(): array|string {
		return $this->method;
	}
	
	/**
	 * Magic method to access properties dynamically.
	 *
	 * @param string $route The property name.
	 *
	 * @return mixed|null The value of the property, or null if the property does not exist.
	 */
	public function __get(string $route): mixed {
		if (property_exists($this, $route)) {
			return $this->$route;
		}
		return null;
	}
}