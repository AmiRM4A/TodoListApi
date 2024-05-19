<?php

namespace App\Services;

use App\Models\LoggedIn;

/**
 * Auth class
 *
 * This class provides a method to retrieve user data from database by using the current logged-in user's token.
 */
class Auth {
	/**
	 * @var array|null $userData Stores the user data retrieved from the database.
	 */
	private static ?array $userData = [];
	
	/**
	 * Retrieves the user data from the database.
	 *
	 * @return array|null The user data or null if not found or an error occurred.
	 */
	public static function user(?string $col = null): mixed {
		// Check if the user data is already cached
		if (is_null(static::$userData)) {
			return null;
		}
		
		if (!is_null($col) && !empty(static::$userData)) {
			return static::$userData[$col] ?? null;
		}
		
		// Return the cached user data if it's not empty
		if (!empty(static::$userData) && is_null($col)) {
			return static::$userData;
		}
		
		// Get the authentication token
		$token = static::getToken();
		
		// Return null if token is invalid
		if (!$token) {
			return null;
		}
		
		try {
			// Fetch the user data from the database using the token
			$userData = LoggedIn::get([
				'users.id',
				'users.name',
				'users.user_name',
				'users.email',
				'users.registered_at',
				'users.last_login',
				'users.last_ip',
				'logged_in.expires_at'
			], [
				'[><]users' => ['user_id' => 'id']
			], [
				'token' => $token
			]);
		} catch (\Throwable) {
			// Reset the user data if an error occurred
			return static::$userData = null;
		}
		
		// If the token data is not found or the token has expired, return an invalid token response
		if (empty($userData) || empty($userData['expires_at']) || strtotime($userData['expires_at']) < time()) {
			return null;
		}
		
		// Unsets the token expiration time from user's data
		unset($userData['expires_at']);
		
		return static::$userData = $userData;
	}
	
	/**
	 * Retrieves the authentication token from the HTTP Authorization header.
	 *
	 * @return string|null The authentication token or null if not found.
	 */
	public static function getToken(): ?string {
		// Extract and return the authentication token from the HTTP Authorization header
		return static::stripAuthToken($_SERVER['HTTP_AUTHORIZATION']) ?: null;
	}
	
	/**
	 * Strips the "Bearer " prefix from an authentication token string.
	 *
	 * @param string $token The authentication token string.
	 *
	 * @return string|null The token string without the "Bearer " prefix, or null if the input is empty.
	 */
	protected static function stripAuthToken(string $token): ?string {
		return trim(str_replace('Bearer ', '', $token)) ?: null;
	}
}