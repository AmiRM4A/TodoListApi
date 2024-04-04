<?php

namespace App\Router;

use App\Core\Request;
use App\Core\Response;

class Router {
	private static bool $isDispatched = false;
	private static ?object $route = null;
	private static array $routes = [];
	private static ?array $params = null;
	private static array $slugs = [];
	
	public const STRING_ACTION_SEPRATOR = '@';
	
	public static function dispatch(): void {
		if (self::$isDispatched) {
			return;
		}
		
		self::$isDispatched = true;
		
		self::findRoute();
		
		if (is_null(self::$route)) {
			response() // Not Found
			->statusCode(404)
				->message('Address not found! Check your url..')
				->json()
				->send(true);
		}
		
		self::getParams();
		
		if (!self::isValidMethod(Request::method(), self::$route->method)) {
			response() // Method Not Allowed
			->statusCode(405)
				->message('Method is invalid, Change it..')
				->json()
				->send();
		}
		
		$result = self::executeAction(self::$route->action);
		if (!$result) {
			response() // Service Unavailable
			->statusCode(503)
				->message('Something went wrong...')
				->json()
				->send();
		}
		
		if (!($result instanceof Response)) {
			echo is_object($result) || is_array($result) ? json_encode($result) : $result;
			return;
		}
		echo $result->send();
	}
	
	private static function executeAction($action): mixed {
		if (empty($action)) {
			return false;
		}
		
		if (is_callable($action)) {
			return $action(...self::$slugs);
		}
		
		if (is_string($action) && strpos($action, self::STRING_ACTION_SEPRATOR, 1) !== false) {
			$action = explode(self::STRING_ACTION_SEPRATOR, $action, 2);
		}
		
		if (!is_array($action) || empty($action)) {
			return false;
		}
		
		[$className, $methodName] = [$action[0], $action[1]];
		
		if (!class_exists($className) || !method_exists($className, $methodName)) {
			return false;
		}
		
		return (new $className)->$methodName(...self::$slugs);
	}
	
	private static function findRoute(): void {
		if (!is_null(self::$route)) {
			return;
		}
		self::getRoutes(Request::method());
		
		$requestUri = Request::uri();
		/** @var ?Route $matchedRoute */
		$matchedRoute = null;
		$foundSlugs = [];
		
		foreach (self::$routes as $route) {
			$pattern_uri = '/^' . str_replace(['/', '{', '}'], ['\/', '(?<', '>[-%\w]+)'], $route->route) . '$/';
			if (preg_match($pattern_uri, $requestUri, $slugs)) {
				$foundSlugs = array_filter($slugs, 'is_string', ARRAY_FILTER_USE_KEY);
				$matchedRoute = $route;
			}
		}
		
		foreach ($matchedRoute->where ?? [] as $slug => $regex) {
			$slugVal = $foundSlugs[$slug];
			if (!preg_match("/$regex/", $slugVal)) {
				return;
			}
		}
		
		static::$route = $matchedRoute;
		static::$slugs = $foundSlugs;
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