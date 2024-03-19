<?php

if (!function_exists('dump')) {
	function dump($data): void {
		$trace = debug_backtrace();
		$caller = array_shift($trace);

		echo '<pre style="background-color: #f0f0f0;border: 1px solid #ddd;padding: 10px;font-family: monospace;font-size: 14px;border-radius: 10px;border-left: 7px solid orange;">';
		echo '<strong>File:</strong> ' . $caller['file'] . ' <strong>Line:</strong> ' . $caller['line'] . "\n\n";
		print_r($data);
		echo '</pre>';
	}
}

if (!function_exists('sendFatalError')) {
	function sendFatalError($message = 'A fatal error occurred!'): void {
		trigger_error($message, E_USER_ERROR);
	}
}