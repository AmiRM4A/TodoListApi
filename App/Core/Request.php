<?php

namespace App\Core;

use App\Helpers\Security;
use App\Helpers\UserAgent;

/**
 * Class Request
 *
 * Represents an HTTP request.
 */
class Request {
	/**
	 * Get the HTTP request method.
	 *
	 * @return string The request method (e.g., GET, POST, etc.).
	 */
	public static function method(): string {
		return $_SERVER['REQUEST_METHOD'];
	}
	
	/**
	 * Get the full URI of the request.
	 *
	 * @return string The full URI of the request.
	 */
	public static function fullUri(): string {
		return $_SERVER['REQUEST_URI'];
	}
	
	/**
	 * Get the URI path of the request.
	 *
	 * @return string The URI path of the request.
	 */
	public static function uri(): string {
		$url = strtok(self::fullUri(), '?');
		if ($url === '/') {
			return $url;
		}
		return trim($url, '/');
	}
	
	/**
	 * Get the host name of the request.
	 *
	 * @return string The host name of the request.
	 */
	public static function host(): string {
		return $_SERVER['HTTP_HOST'];
	}
	
	/**
	 * Get the POST data of the request after sanitization.
	 *
	 * @return array|bool The sanitized POST data.
	 */
	public static function post(): array|bool {
		return Security::cleanInputData($_POST, FILTER_UNSAFE_RAW);
	}
	
	/**
	 * Get the GET data of the request after sanitization.
	 *
	 * @return array|bool The sanitized GET data.
	 */
	public static function get(): array|bool {
		return Security::cleanInputData($_GET, FILTER_UNSAFE_RAW);
	}
	
	/**
	 * Get all parameters (GET and POST) of the request after sanitization.
	 *
	 * @return array All sanitized parameters.
	 */
	public static function params(): array {
		return array_merge(self::get(), self::post());
	}
	
	/**
	 * Get the body parameters of the request.
	 *
	 * @return array The body parameters of the request.
	 */
	public static function bodyParams(): array {
		parse_str(file_get_contents('php://input'), $body);
		return $body;
	}
	
	/**
	 * Get a parameter value from the request.
	 *
	 * @param string $key The parameter key.
	 * @param mixed|null $default The default value if the parameter is not found.
	 *
	 * @return mixed The parameter value or the default value.
	 */
	public static function param(string $key, mixed $default = null): mixed {
		return self::params()[$key] ?? $default;
	}
	
	/**
	 * Get a body parameter value from the request.
	 *
	 * @param string $key The parameter key.
	 * @param mixed|null $default The default value if the parameter is not found.
	 *
	 * @return mixed The body parameter value or the default value.
	 */
	public static function bodyParam(string $key, mixed $default = null): mixed {
		return self::bodyParams()[$key] ?? $default;
	}
	
	/**
	 * Get the IP address of the client.
	 *
	 * @return string The IP address of the client.
	 */
	public static function ip(): string {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //Ip From Share Internet
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //Ip Pass From Proxy
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		
		return $_SERVER['REMOTE_ADDR'];
	}
	
	/**
	 * Get the User-Agent object representing the client's user agent.
	 *
	 * @return object The User-Agent object.
	 */
	public static function agent(): object {
		return new UserAgent($_SERVER['HTTP_USER_AGENT']);
	}
	
	/**
	 * Get all parameters (GET, POST, and body) of the request after sanitization.
	 *
	 * @return array All sanitized parameters.
	 */
	public static function fullParams(): array {
		return array_merge(self::params(), self::bodyParams());
	}
	
	/**
	 * Magic method to dynamically get parameters as properties of the request object.
	 *
	 * @param string $name The parameter name.
	 *
	 * @return mixed|null The parameter value or null if not found.
	 */
	public function __get(string $name) {
		$args = self::fullParams();
		return $args[$name] ?? null;
	}
}