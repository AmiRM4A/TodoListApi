<?php

use App\Core\Request;
use App\Core\Response;
use App\Helpers\UserAgent;

/**
 * Custom Utility Functions
 *
 * This file defines custom utility functions for debugging, error handling, and HTTP response creation.
 */

if (!function_exists('dump')) {
	/**
	 * Dump variable contents for debugging.
	 *
	 * @param mixed $output The variable to be dumped.
	 *
	 * @return void
	 */
	function dump(mixed $output): void {
		$trace = debug_backtrace();
		$caller = array_shift($trace);
		
		echo '<pre style="background-color: #f0f0f0;border: 1px solid #ddd;padding: 10px;font-family: monospace;font-size: 14px;border-radius: 10px;border-left: 7px solid orange;">';
		echo '<strong>File:</strong> ' . $caller['file'] . ' <strong>Line:</strong> ' . $caller['line'] . "\n\n";
		var_dump($output);
		echo '</pre>' . "\n";
	}
}

if (!function_exists('dd')) {
	/**
	 * Dump variable contents and halt execution.
	 *
	 * @param mixed $output The variable to be dumped.
	 *
	 * @return void
	 */
	function dd(mixed $output): void {
		dump($output);
		die;
	}
}

if (!function_exists('sendFatalError')) {
	/**
	 * Send a fatal error message.
	 *
	 * @param string $message The error message.
	 *
	 * @return void
	 */
	function sendFatalError(string $message = 'A fatal error occurred!'): void {
		trigger_error($message, E_USER_ERROR);
	}
}

if (!function_exists('agent')) {
	/**
	 * Get the UserAgent object from the current request.
	 *
	 * @return UserAgent The UserAgent object.
	 */
	function agent(): UserAgent {
		return Request::agent();
	}
}

if (!function_exists('response')) {
	/**
	 * Create a new Response object.
	 *
	 * @return Response A new Response object.
	 */
	function response(): object {
		return new Response();
	}
}

/**
 * Retrieve a parameter value from the current request.
 *
 * This function retrieves the value of a parameter from the current request. It likely abstracts the process
 * of accessing request parameters, query parameters, request body parameters, and raw request data.
 *
 * @param string $key The key of the parameter to be retrieved.
 *
 * @return mixed The value of the requested parameter.
 */
if (!function_exists('param')) {
	function param($key): mixed {
		return Request::param($key);
	}
}

/**
 * Retrieve a query parameter value from the current request.
 *
 * This function retrieves the value of a query parameter from the current request.
 *
 * @param string $key The key of the query parameter to be retrieved.
 *
 * @return mixed The value of the requested query parameter.
 */
if (!function_exists('queryParam')) {
	function queryParam(string $key): mixed {
		return Request::queryParam($key);
	}
}

/**
 * Retrieve a request body parameter value from the current request.
 *
 * This function retrieves the value of a request body parameter from the current request.
 *
 * @param string $key The key of the request body parameter to be retrieved.
 *
 * @return mixed The value of the requested request body parameter.
 */
if (!function_exists('bodyParam')) {
	function bodyParam(string $key): mixed {
		return Request::bodyParam($key);
	}
}

/**
 * Retrieve a raw parameter value from the current request.
 *
 * This function retrieves the value of a raw parameter from the current request.
 *
 * @param string $key The key of the raw parameter to be retrieved.
 *
 * @return mixed The value of the requested raw parameter.
 */
if (!function_exists('rawParam')) {
	function rawParam(string $key): mixed {
		return Request::rawParam($key);
	}
}
}