<?php

namespace App\Middlewares;

use App\Services\Auth as AuthService;
use App\Exceptions\MiddlewareException;

/**
 * Auth middleware
 *
 * This middleware class is responsible for authenticating requests by validating the provided token.
 * It checks if the token is valid by verifying it against the LoggedIn model.
 */
class Auth {
	/**
	 * Handle the validity of the incoming request.
	 *
	 * This method checks the validity of the provided token using the AuthService.
	 * If the token is valid, it allows the request to proceed.
	 * If the token is invalid, it throws a MiddlewareException.
	 *
	 * @return void
	 * @throws MiddlewareException If the token is invalid or if any other exception occurs during the token validation process.
	 */
	public function handle(): void {
		// Retrieve the user data using the provided token
		
		if (is_null(AuthService::user())) {
		// If the user data is null (invalid token), throw a MiddlewareException
			throw new MiddlewareException('Invalid or Expired token', 401);
		}
		
		// If the token is valid, allow the request to proceed
		// (No further action is required)
	}
}