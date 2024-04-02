<?php

use App\Core\Request;
use App\Core\Response;
use App\Helpers\UserAgent;

if (!function_exists('dump')) {
	function dump($output): void {
		$trace = debug_backtrace();
		$caller = array_shift($trace);
		
		echo '<pre style="background-color: #f0f0f0;border: 1px solid #ddd;padding: 10px;font-family: monospace;font-size: 14px;border-radius: 10px;border-left: 7px solid orange;">';
		echo '<strong>File:</strong> ' . $caller['file'] . ' <strong>Line:</strong> ' . $caller['line'] . "\n\n";
		var_dump($output);
		echo '</pre>' . "\n";
	}
}

if (!function_exists('dd')) {
	function dd($output): void {
		dump($output);
		die;
	}
}

if (!function_exists('sendFatalError')) {
	function sendFatalError($message = 'A fatal error occurred!'): void {
		trigger_error($message, E_USER_ERROR);
	}
}

if (!function_exists('agent')) {
	function agent(): UserAgent {
		return Request::agent();
	}
}

if (!function_exists('response')) {
	function response(): object {
		return new Response();
	}
}