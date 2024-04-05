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