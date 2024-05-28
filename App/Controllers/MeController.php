<?php

namespace App\Controllers;

use App\Services\Auth;
use App\Core\Response;

/**
 * MeController class
 *
 * This controller returns the data of current logged-in user as response data.
 */
class MeController {
	/**
	 * Retrieves the login data for the authenticated user.
	 *
	 * @return Response The response object containing the user data or an error message.
	 */
	public function getLoginData(): Response {
		// If user data is found, return a 200 OK response with the user data
		return response(200, 'User data retrieved successfully.', Auth::user(), true);
	}
}