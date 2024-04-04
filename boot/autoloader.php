<?php

spl_autoload_register(function ($className) {
	$filePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, PROJ_DIR . DIRECTORY_SEPARATOR . $className . '.php');
	if (file_exists($filePath) && is_readable($filePath)) {
		require $filePath;
	} else {
		sendFatalError('Could not load the file: ' . $filePath . PHP_EOL);
	}
});
