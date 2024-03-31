<?php

namespace App\Router;

use App\Helpers\Str;

class Route {
	private static array $routes = [];
	
	protected string $route;
	protected array|string $method;
	protected mixed $action;
	protected array $where = [];
	
	public function __construct(string $route, array|string $method, callable|array|string $action) {
		$this->route = $route;
		$this->method = (array) Str::toUpperCase($method);
		$this->action = $action;
		static::add($this);
	}
	
	public static function new(string $route, array|string $method, callable|array|string $action): static {
		return new static(...func_get_args());
	}
	
	private static function add(Route $route): void {
		static::$routes[$route->route] = $route;
	}
	
	public function where(string $param, string $regex): static {
		$this->where[$param] = $regex;
		return $this;
	}
	
	public static function get(string $route, callable|array|string $action): static {
		return static::new($route, 'GET', $action);
	}
	
	public static function post(string $route, callable|array|string $action): static {
		return static::new($route, 'POST', $action);
	}
	
	public static function put(string $route, callable|array|string $action): static {
		return static::new($route, 'PUT', $action);
	}
	
	public static function delete(string $route, callable|array|string $action): static {
		return static::new($route, 'DELETE', $action);
	}
	
	public static function patch(string $route, callable|array|string $action): static {
		return static::new($route, 'PATCH', $action);
	}
	
	public static function getRoutes(): array {
		return static::$routes;
	}
	
	public function method(): array|string {
		return $this->method;
	}
	
	public function __get($route) {
		if (property_exists($this, $route)) {
			return $this->$route;
		}
	}
}