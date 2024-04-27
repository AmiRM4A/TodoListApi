<?php

/**
 * Registers an autoloader function to load classes dynamically.
 */
spl_autoload_register(function ($className) {
	// Convert class namespace to file path
	$filePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, PROJ_DIR . DIRECTORY_SEPARATOR . $className . '.php');
	
	// Check if the file exists and is readable
	if (file_exists($filePath) && is_readable($filePath)) {
		// Require the class file
		require $filePath;
	} else {
		// Trigger a fatal error if the file cannot be loaded
		sendFatalError('Could not load the file: ' . $filePath . PHP_EOL);
	}
});