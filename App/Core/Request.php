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
	 * This method returns the HTTP request method, such as "GET", "POST", "PUT", "DELETE", etc.
	 *
	 * @return string The request method.
	 */
	public static function method(): string {
		return $_SERVER['REQUEST_METHOD'];
	}
	
	/**
	 * Get the full URI of the request.
	 *
	 * This method returns the full URI of the current request, including the query string.
	 *
	 * @return string The full URI of the request.
	 */
	public static function fullUri(): string {
		return $_SERVER['REQUEST_URI'];
	}
	
	/**
	 * Get the URI path of the request.
	 *
	 * This method returns the URI path of the current request, excluding the query string.
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
	 * This method returns the host name of the current request.
	 *
	 * @return string The host name of the request.
	 */
	public static function host(): string {
		return $_SERVER['HTTP_HOST'];
	}
	
	/**
	 * Get the POST data of the request after sanitization.
	 *
	 * This method returns the POST data of the current request, with the input data being sanitized.
	 *
	 * @return array|bool The sanitized POST data, or false if the data cannot be parsed.
	 */
	public static function post(): array|bool {
		return Security::cleanInputData($_POST, FILTER_UNSAFE_RAW);
	}
	
	/**
	 * Get the GET data of the request after sanitization.
	 *
	 * This method returns the GET data of the current request, with the input data being sanitized.
	 *
	 * @return array|bool The sanitized GET data, or false if the data cannot be parsed.
	 */
	public static function get(): array|bool {
		return Security::cleanInputData($_GET, FILTER_UNSAFE_RAW);
	}
	
	/**
	 * Get all parameters (GET, POST, and body) of the request after sanitization.
	 *
	 * This method returns an array containing all the sanitized parameters from the current request,
	 * including GET, POST, and raw request body parameters.
	 *
	 * @return array All sanitized parameters.
	 */
	public static function params(): array {
		return array_merge(self::get(), self::post(), self::rawParams());
	}
	
	/**
	 * Get the raw params.
	 *
	 * This method returns the raw request body parameters.
	 *
	 * @return array The body parameters of the request.
	 */
	public static function rawParams(): array {
		parse_str(file_get_contents('php://input'), $body);
		return $body;
	}
	
	/**
	 * Get a parameter value from the request.
	 *
	 * This method retrieves the value of a parameter from the current request, with a default value
	 * provided if the parameter is not found.
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
	 * This method retrieves the value of a raw request body parameter, with a default value
	 * provided if the parameter is not found.
	 *
	 * @param string $key The parameter key.
	 * @param mixed|null $default The default value if the parameter is not found.
	 *
	 * @return mixed The body parameter value or the default value.
	 */
	public static function rawParam(string $key, mixed $default = null): mixed {
		return self::rawParams()[$key] ?? $default;
	}
	
	/**
	 * Get a query parameter value from the request.
	 *
	 * This method retrieves the value of a query parameter, with a default value
	 * provided if the parameter is not found.
	 *
	 * @param string $key The parameter key.
	 * @param mixed|null $default The default value if the parameter is not found.
	 *
	 * @return mixed The query parameter value or the default value.
	 */
	public static function queryParam(string $key, mixed $default = null): mixed {
		return self::get()[$key] ?? $default;
	}
	
	/**
	 * Get a request body parameter value from the request.
	 *
	 * This method retrieves the value of a request body parameter, with a default value
	 * provided if the parameter is not found.
	 *
	 * @param string $key The parameter key.
	 * @param mixed|null $default The default value if the parameter is not found.
	 *
	 * @return mixed The request body parameter value or the default value.
	 */
	public static function bodyParam(string $key, mixed $default = null): mixed {
		return self::post() ?? $default;
	}
	
	/**
	 * Get the IP address of the client.
	 *
	 * This method returns the IP address of the client making the current request.
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
	 * This method returns a `UserAgent` object representing the client's user agent information.
	 *
	 * @return object The User-Agent object.
	 */
	public static function agent(): object {
		return new UserAgent($_SERVER['HTTP_USER_AGENT']);
	}
	
	/**
	 * Magic method to dynamically get parameters as properties of the request object.
	 *
	 * This method allows you to access request parameters as properties of the `Request` object.
	 *
	 * @param string $name The parameter name.
	 *
	 * @return mixed|null The parameter value or null if not found.
	 */
	public function __get(string $name) {
		return self::params()[$name] ?? null;
	}
}