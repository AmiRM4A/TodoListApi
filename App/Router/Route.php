<?php

namespace App\Router;

use App\Helpers\Str;

class Route {
	private static array $routes = [];

	public static function add(string $name, array|string $method, callable|array|string $action): void {
		self::$routes[] = [
			'name' => $name,
			'method' => Str::toUpperCase($method),
			'action' => $action
		];
	}

	public static function get(string $name, callable|array|string $action): void {
		self::add($name, 'GET', $action);
	}

	public static function post(string $name, callable|array|string $action): void {
		self::add($name, 'POST', $action);
	}

	public static function put(string $name, callable|array|string $action): void {
		self::add($name, 'PUT', $action);
	}

	public static function delete(string $name, callable|array|string $action): void {
		self::add($name, 'DELETE', $action);
	}

	public static function patch(string $name, callable|array|string $action): void {
		self::add($name, 'PATCH', $action);
	}

	public static function getRoutes(): array {
		return self::$routes;
	}
}
