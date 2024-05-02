<?php

namespace App\Middlewares;

use Exception;
use App\Core\Response;
use App\Models\LoggedIn;

/**
 * Auth middleware
 *
 * This middleware class is responsible for authenticating requests by validating the token cookie.
 * It checks if a token cookie exists, and if so, it verifies its validity against the LoggedIn model.
 */
class Auth {
	/**
	 * Handle the validity of incoming request.
	 *
	 * This method checks the validity of the token cookie and returns an appropriate response.
	 *
	 * @throws Exception If there's an issue with the database connection or query.
	 *
	 * @return Response|void The response object containing the HTTP status code and message.
	 */
	public function handle() {
		$token = $_COOKIE['token'] ?? null;
		
		if (!$token || !is_string($token)) {
			return response(401, 'Your authentication token is missing or invalid.');
		}
		
		// Retrieve the token data from the LoggedIn model
		try {
			$tokenData = LoggedIn::get('*', ['token' => $token]);
		} catch (Exception $e) {
			return response(503, $e->getMessage());
		}
		
		// If the token data is not found or the token has expired, return an invalid token response
		if (!$tokenData || strtotime($tokenData['expires_at']) < time()) {
			return response(401, 'Invalid token!');
		}
	}
}