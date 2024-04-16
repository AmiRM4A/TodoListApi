<?php

use App\Core\Request;
use App\Core\Response;
use App\Helpers\UserAgent;

/**
 * Custom Utility Functions
 *
 * This file defines a set of custom utility functions for debugging, error handling, and HTTP response creation.
 */

/**
 * Dump variable contents for debugging.
 *
 * This function is used to output the contents of a variable or value in a formatted, pre-styled block. It includes
 * information about the file and line number where the function was called.
 *
 * @param mixed $output The variable or value to be dumped.
 *
 * @return void
 */
if (!function_exists('dump')) {
	function dump(mixed $output): void {
		$trace = debug_backtrace();
		$caller = array_shift($trace);
		
		echo '<pre style="display: inline-block; background-color: #f0f0f0;border: 1px solid #ddd;padding: 10px;font-family: monospace;font-size: 14px;border-radius: 10px;border-left: 7px solid orange;">';
		echo '<strong>File:</strong> ' . $caller['file'] . ' <strong>Line:</strong> ' . $caller['line'] . "\n\n";
		var_dump($output);
		echo '</pre>' . "\n";
	}
}

/**
 * Dump variable contents and halt execution.
 *
 * This function is similar to the `dump()` function, but it also halts the execution of the script after outputting
 * the variable contents.
 *
 * @param mixed $output The variable or value to be dumped.
 *
 * @return void
 */
if (!function_exists('dd')) {
	function dd(mixed $output): void {
		dump($output);
		die;
	}
}

/**
 * Send a fatal error message.
 *
 * This function is used to trigger a fatal error with a custom error message. It can be called when an
 * unrecoverable error occurs in the application.
 *
 * @param string $message The error message to be displayed.
 *
 * @return void
 */
if (!function_exists('sendFatalError')) {
	function sendFatalError(string $message = 'A fatal error occurred!'): void {
		trigger_error($message, E_USER_ERROR);
	}
}

/**
 * Get the UserAgent object from the current request.
 *
 * This function returns the `UserAgent` object, which likely contains information about the client's browser,
 * operating system, and other relevant details.
 *
 * @return UserAgent The UserAgent object.
 */
if (!function_exists('agent')) {
	function agent(): UserAgent {
		return Request::agent();
	}
}

/**
 * Create a new Response object.
 *
 * This function creates and returns a new `Response` object, which can be used to construct and send HTTP
 * responses from the application.
 *
 * @param int|null $code The HTTP status code for the response.
 * @param string|null $message The message to be included in the response.
 *
 * @return Response A new Response object.
 */
if (!function_exists('response')) {
	function response(?int $code = null, ?string $message = null): Response {
		return (new Response())->statusCode($code)->message($message);
	}
}

/**
 * Retrieve a parameter value from the current request.
 *
 * This function retrieves the value of a parameter from the current request. It likely abstracts the process
 * of accessing request parameters, query parameters, request body parameters, and raw request data.
 *
 * @param string $key The key of the parameter to be retrieved.
 * @param mixed $default The default value to be returned if the parameter is not found.
 *
 * @return mixed The value of the requested parameter, or the default value if not found.
 */
if (!function_exists('param')) {
	function param(string $key, mixed $default = null): mixed {
		return Request::param($key, $default);
	}
}

/**
 * Retrieve a query parameter value from the current request.
 *
 * This function retrieves the value of a query parameter from the current request.
 *
 * @param string $key The key of the query parameter to be retrieved.
 * @param mixed $default The default value to be returned if the query parameter is not found.
 *
 * @return mixed The value of the requested query parameter, or the default value if not found.
 */
if (!function_exists('queryParam')) {
	function queryParam(string $key, mixed $default = null): mixed {
		return Request::queryParam($key, $default);
	}
}

/**
 * Retrieve a request body parameter value from the current request.
 *
 * This function retrieves the value of a request body parameter from the current request.
 *
 * @param string $key The key of the request body parameter to be retrieved.
 * @param mixed $default The default value to be returned if the request body parameter is not found.
 *
 * @return mixed The value of the requested request body parameter, or the default value if not found.
 */
if (!function_exists('bodyParam')) {
	function bodyParam(string $key, mixed $default = null): mixed {
		return Request::bodyParam($key, $default);
	}
}

/**
 * Retrieve a raw parameter value from the current request.
 *
 * This function retrieves the value of a raw parameter from the current request.
 *
 * @param string $key The key of the raw parameter to be retrieved.
 * @param mixed $default The default value to be returned if the raw parameter is not found.
 *
 * @return mixed The value of the requested raw parameter, or the default value if not found.
 */
if (!function_exists('rawParam')) {
	function rawParam(string $key, mixed $default = null): mixed {
		return Request::rawParam($key, $default);
	}
}

/**
 * Create a new Request object.
 *
 * This function creates and returns a new `Request` object, which can be used to interact with the current
 * HTTP request.
 *
 * @return Request A new Request object.
 */
if (!function_exists('request')) {
	function request(): Request {
		return new Request();
	}
}

/**
 * Apply a callback to a value and return the value.
 *
 * This function applies a callback to a value and returns the value, allowing for method chaining and functional
 * programming techniques.
 *
 * @param mixed $value The value to be passed to the callback.
 * @param callable $callback The callback function to be applied to the value.
 *
 * @return mixed The original value, after the callback has been applied.
 */
if (!function_exists('tap')) {
	function tap(mixed $value, callable $callback): mixed {
		return $callback($value);
	}
}