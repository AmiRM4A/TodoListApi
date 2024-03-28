<?php

namespace App\Router;

use App\Core\Request;

class Router {
	private static bool $isDispatched = false;
	private static null|array $route = null;
	private static array $routes = [];
	private static null|array $params = null;
	const STRING_ACTION_SEPRATOR = '@';
	const CONTROLLERS_BASE_PATH  = 'App\Controllers\\';
	
	public static function dispatch(): void {
		if (self::$isDispatched) {
			return;
		}
		
		self::getRoutes();
		self::findRoute();
		
		if (is_null(self::$route)) {
			dd('404: Route Not Found');
		} // Response => 404 Not Found
		
		self::getParams();
		
		if (!self::isValidMethod(Request::method(), self::$route['method'])) {
			dd('405: Invalid method');
		} // Response => 405 Method Not Valid
		
		if (!self::executeAction(self::$route['action'])) {
			dd('404');
		}
		
		self::$isDispatched = true;
	}
	
	private static function executeAction($action): bool {
		if (empty($action)) {
			return false;
		}
		
		if (is_callable($action)) {
			$action(self::$params);
			return true;
		}
		
		if (is_string($action) && str_contains($action, self::STRING_ACTION_SEPRATOR)) {
			$action = explode(self::STRING_ACTION_SEPRATOR, $action);
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
		
		$requestUri = Request::url();
		
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
	
	private static function getRoutes(): void {
		if (!self::$routes) {
			self::$routes = Route::getRoutes();
		}
	}
	
	private static function isValidMethod($request_method, $route_methods): bool {
		return (bool) in_array($request_method, $route_methods, true);
	}
}