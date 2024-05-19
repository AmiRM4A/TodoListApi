<?php

namespace App\Middlewares;

/**
 * CORS (Cross-Origin Resource Sharing) Middleware
 *
 * This middleware is responsible for handling CORS-related headers in the application's responses.
 * It ensures that the client (browser, mobile app, etc.) can make cross-origin requests to the server
 * without being blocked by the browser's same-origin policy.
 */
class CORS {
	/**
	 * Handle the incoming request and add the necessary CORS headers.
	 *
	 * @return void
	 */
	public function handle(): void {
		// Allow requests from any origin (*)
		$this->setAccessControlAllowOrigin('*');
		
		// Allowed HTTP methods
		$this->setAccessControlAllowMethods('PUT, GET, POST, DELETE, OPTIONS');
		
		// Allowed headers for the request
		$this->setAccessControlAllowHeaders('Authorization, Content-Type');
		
		// Cache the preflight response for 24 hours (86400 seconds)
		$this->setAccessControlMaxAge(86400);
		
		// If the request method is OPTIONS, exit the script
		// This handles the preflight request for CORS
		if (strtolower($_SERVER['REQUEST_METHOD']) === 'options') {
			exit();
		}
	}
	
	/**
	 * Set the Access-Control-Allow-Origin header.
	 *
	 * @param string $origin The allowed origin(s)
	 *
	 * @return void
	 */
	private function setAccessControlAllowOrigin(string $origin): void {
		header('Access-Control-Allow-Origin: ' . $origin);
	}
	
	/**
	 * Set the Access-Control-Allow-Methods header.
	 *
	 * @param string $methods The allowed HTTP methods
	 *
	 * @return void
	 */
	private function setAccessControlAllowMethods(string $methods): void {
		header('Access-Control-Allow-Methods: ' . $methods);
	}
	
	/**
	 * Set the Access-Control-Allow-Headers header.
	 *
	 * @param string $headers The allowed headers
	 *
	 * @return void
	 */
	private function setAccessControlAllowHeaders(string $headers): void {
		header('Access-Control-Allow-Headers: ' . $headers);
	}
	
	/**
	 * Set the Access-Control-Max-Age header.
	 *
	 * @param int $age The maximum age (in seconds) to cache the preflight response
	 *
	 * @return void
	 */
	private function setAccessControlMaxAge(int $age): void {
		header('Access-Control-Max-Age: ' . $age);
	}
}