<?php

namespace App\Router;

use App\Core\Request;
use App\Core\Response;

/**
 * Class Router
 *
 * Handles routing for incoming HTTP requests.
 */
class Router {
	private static bool $isDispatched = false;
	private static ?object $route = null;
	private static array $routes = [];
	private static ?array $params = null;
	private static array $slugs = [];
	
	public const STRING_ACTION_SEPRATOR = '@';
	
	/**
	 * Dispatches the request to the appropriate route handler.
	 *
	 * @return void
	 */
	public static function dispatch(): void {
		if (self::$isDispatched) {
			return;
		}
		
		self::$isDispatched = true;
		
		self::findRoute();
		
		if (is_null(self::$route)) {
			response() // Not Found
			->statusCode(404)
				->message('Address not found! Check your URL...')
				->json()
				->send(true);
		}
		
		self::getParams();
		
		if (!self::isValidMethod(Request::method(), self::$route->method)) {
			response() // Method Not Allowed
			->statusCode(405)
				->message(DEV_MODE ? 'Method Not Allowed... (Available Methods: ' . implode(' - ', self::$route->method()) . ')' : 'Method Not Allowed')
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
	
	/**
	 * Executes the action associated with the route.
	 *
	 * @param mixed $action The action to execute.
	 *
	 * @return mixed The result of the action execution.
	 */
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
	
	/**
	 * Finds the matching route for the current request.
	 *
	 * @return void
	 */
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
	
	/**
	 * Retrieves parameters from the request.
	 *
	 * @return void
	 */
	private static function getParams(): void {
		if (!is_null(self::$params)) {
			return;
		}
		
		self::$params = Request::fullParams();
	}
	
	/**
	 * Retrieves routes filtered by method.
	 *
	 * @param string|null $method The HTTP method to filter routes by.
	 *
	 * @return array The filtered routes.
	 */
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
	
	/**
	 * Checks if the request method is valid for the route.
	 *
	 * @param string $request_method The HTTP request method.
	 * @param array $route_methods The allowed methods for the route.
	 *
	 * @return bool True if the method is valid, false otherwise.
	 */
	private static function isValidMethod(string $request_method, array $route_methods): bool {
		return in_array($request_method, $route_methods, true);
	}
}