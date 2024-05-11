<?php

namespace App\Controllers;

use App\Core\Response;
use App\Models\LoggedIn;
use App\Exceptions\DBException;
use App\Exceptions\ModelException;

/**
 * MeController
 *
 * This controller class is responsible for getting user's data based on their token.
 */
class MeController {
	/**
	 * Retrieves user data based on the provided token.
	 *
	 * @throws DBException If there is an error retrieving data from the database.
	 * @throws ModelException If there is an error with the LoggedIn model.
	 *
	 * @return Response A JSON response containing the user data or an error message.
	 */
	public function getLoginData(): Response {
		$authHeader = json_decode($_SERVER['HTTP_AUTHORIZATION']);
		$token = trim(str_replace("Bearer ", "", $authHeader->token)) ?: null;

		/**
		 * Selects all columns (*) from the `logged_in` table,
		 * joins the `users` table on the `user` column from `logged_in` and `id` column from `users`,
		 * and filters the results where the `token` column matches the provided `$token` value.
		 */
		$data = LoggedIn::select([
			'users.id',
			'users.name',
			'users.user_name',
			'users.email',
			'users.registered_at',
			'users.last_login',
			'users.last_ip'
		], [
			'[><]users' => ['user_id' => 'id']
		], [
			'token' => $token
		]);
		
		// If no data is found, return a 404 JSON response with an error message
		if (!$data) {
			return response(404, 'User data not found for the provided token.');
		}
		
		// If data is found, return a 200 JSON response with the user data
		return response(200, 'User data retrieved successfully.', $data);
	}
}