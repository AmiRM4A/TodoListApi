<?php

namespace App\Router;

use App\Helpers\Str;

class Route {
	private static $routes = [];

	public static function add(string $name, array|string $method, callable|array|string $action): void {
		self::$routes[] = [
			'name' => $name,
			'method' => Str::toUpperCase($method),
			'action' => $action
		];
	}

	public static function get(string $name, callable|array|string $action): void {
		static::add($name, 'GET', $action);
	}

	public static function post(string $name, callable|array|string $action): void {
		static::add($name, 'POST', $action);
	}

	public static function put(string $name, callable|array|string $action): void {
		static::add($name, 'PUT', $action);
	}

	public static function delete(string $name, callable|array|string $action): void {
		static::add($name, 'DELETE', $action);
	}

	public static function patch(string $name, callable|array|string $action): void {
		static::add($name, 'PATCH', $action);
	}

	public static function getRoutes(): array {
		return static::$routes;
	}
}
