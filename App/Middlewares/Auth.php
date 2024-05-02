<?php

namespace App\Middlewares;

use Throwable;
use App\Core\Response;
use App\Models\LoggedIn;
use App\Exceptions\DBException;
use App\Exceptions\ModelException;
use App\Exceptions\MiddlewareException;

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
	 * @throws DBException If there is an error retrieving data from the database.
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws MiddlewareException If any other exception occurs during the token validation process.
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
			$tokenExpTime = LoggedIn::get('expires_at', ['token' => $token]);
		} catch (DBException|ModelException $e) {
			throw $e;
		} catch (Throwable $e) {
			throw new MiddlewareException($e->getMessage());
		}
		
		// If the token data is not found or the token has expired, return an invalid token response
		if (!$tokenExpTime || strtotime($tokenExpTime) < time()) {
			return response(401, 'Invalid token!');
		}
	}
}