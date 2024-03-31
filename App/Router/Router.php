<?php

namespace App\Router;

use App\Core\Request;

class Router {
	private static bool $isDispatched = false;
	private static ?object $route = null;
	private static array $routes = [];
	private static ?array $params = null;
	
	public const STRING_ACTION_SEPRATOR = '@';
	public const CONTROLLERS_BASE_PATH  = 'App\Controllers\\';
	
	public static function dispatch(): void {
		if (self::$isDispatched) {
			return;
		}
		
		self::$isDispatched = true;
		
		self::findRoute();
		
		if (is_null(self::$route)) {
			dd('404: Route Not Found'); // TODO: Change to response (404 - Not Found)
		}
		
		self::getParams();
		
		if (!self::isValidMethod(Request::method(), self::$route->method)) {
			dd('405: Invalid method'); // TODO: Change to response (405 - Method Not Allowed)
		}
		
		if (!self::executeAction(self::$route->action)) {
			dd('503'); // TODO: Change to response (503 - Server Unavailable)
		}
	}
	
	private static function executeAction($action): bool {
		if (empty($action)) {
			return false;
		}
		
		if (is_callable($action)) {
			$action(self::$params);
			return true;
		}
		
		if (is_string($action) && strpos($action, self::STRING_ACTION_SEPRATOR, 1) !== false) {
			$action = explode(self::STRING_ACTION_SEPRATOR, $action, 2);
		}
		
		if (!is_array($action) || empty($action)) {
			return false;
		}
		
		$className = self::CONTROLLERS_BASE_PATH . $action[0];
		$methodName = $action[1];
		
		if (class_exists($className) && method_exists($className, $methodName)) {
			$class = new $className;
			$class->$methodName(self::$params);
			return true;
		}
	}
	
	private static function findRoute(): void {
		if (!is_null(self::$route)) {
			return;
		}
		self::getRoutes(Request::method());
		
		$requestUri = Request::uri();
		
		foreach (self::$routes as $route) {
			if ($route['name'] !== $requestUri) {
				continue;
			}
			self::$route = $route;
			return;
		}
	}
	
	private static function getParams(): void {
		if (!is_null(self::$params)) {
			return;
		}
		
		self::$params = Request::fullParams();
	}
	
	public static function getRoutes(?string $method = null): array {
		if (!self::$routes) {
			self::$routes = Route::getRoutes();
		}
		
		if ($method === null) {
			return self::$routes;
		}
		
		return array_filter(self::$routes, function (Route $route) use ($method) {
			return in_array($method, $route->method(), true);
		});
	}
	
	private static function isValidMethod($request_method, $route_methods): bool {
		return in_array($request_method, $route_methods, true);
	}
}