<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Response;
use App\Models\LoggedIn;
use App\Exceptions\DBException;
use App\Exceptions\ModelException;

/**
 * AuthController class
 *
 * This class handles authentication-related operations, such as user login.
 */
class AuthController {
	/**
	 * Handle the user login process.
	 *
	 * This function checks if the user is already logged in by looking for the 'token' cookie.
	 *
	 * @throws DBException If there is an error retrieving data from the database.
	 * @throws ModelException If there is an error with the LoggedIn model.
	 *
	 * @return Response An array containing the HTTP status code and response message.
	 */
	public function handleLogin(): Response {
		if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
			return response(200, 'You are already have authentication data.');
		}
		
		$email = param('email', null);
		$password = param('password', null);
		
		if (is_null($email) || is_null($password)) {
			return response(400, 'Please provide both email and password.');
		}
		
		// Get the user from the database based on the provided email and password
		$user = User::get([
			'id',
			'email',
			'password',
			'salt'
		], null, ['email' => $email]);
		
		if (!$user) {
			return response(404, 'User not found with the provided email address.');
		}
		
		// Check if the password is incorrect
		$hashedPassword = md5($password . $user['salt']);
		if ($hashedPassword !== $user['password']) {
			return response(401, 'Invalid email or password.');
		}
		
		// Generate a new token (32 length) and set the expiration time (1 week from now)
		$token = getRandomString();
		$expTime = date('Y-m-d H:i:s', strtotime('+ ' . TOKEN_EXPIRE_TIME));
		
		// Store the token, expiration time, and user ID in the LoggedIn model
		LoggedIn::insert([
			'token' => $token,
			'expires_at' => $expTime,
			'user_id' => $user['id']
		]);
		
		return response(200, 'Authentication successful. You are now logged in.', ['token' => $token]);
	}
}