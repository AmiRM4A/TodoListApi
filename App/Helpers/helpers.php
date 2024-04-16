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

/**
 * Get the current time.
 *
 * This function returns the current time in the format 'Y-m-d H:i:s'.
 *
 * @return string The current time.
 */
if (!function_exists('currentTime')) {
	function currentTime(): string {
		return date('Y-m-d H:i:s');
	}
}

/**
 * Check if a given string is a valid email address.
 *
 * This function uses a regular expression to validate the format of the input email address.
 *
 * @param string $email The email address to be validated.
 *
 * @return bool True if the email address is valid, false otherwise.
 */
if (!function_exists('isEmail')) {
	function isEmail(string $email): bool {
		return preg_match('/[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}/', $email);
	}
}

/**
 * Sanitize a string input.
 *
 * This function performs the following operations on the input string:
 * - Trims leading and trailing whitespace
 * - Strips HTML tags
 * - Escapes special characters
 * - Removes any additional whitespace
 *
 * @param ?string $input The input string to be sanitized.
 *
 * @return bool|string The sanitized string, or false if the input is null.
 */
if (!function_exists('sanitizeStr')) {
	function sanitizeStr(?string $input): bool|string {
		if (!$input) {
			return false;
		}
		
		// Trim the input
		$input = trim($input);
		
		// Strip HTML tags
		$input = strip_tags($input);
		
		// Escape special characters
		$input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
		
		// Remove any additional whitespace
		return preg_replace('/\s+/', ' ', $input);
	}
}