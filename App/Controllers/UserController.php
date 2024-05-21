<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Request;
use App\Exceptions\DBException;
use App\Exceptions\ModelException;

/**
 * UserController class
 *
 * Handles CRUD operations for users.
 */
class UserController {
	/**
	 * Retrieves all users.
	 *
	 * @return mixed The retrieved users.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function index(): mixed {
		return User::select('*');
	}
	
	/**
	 * Retrieves a specific user by its ID.
	 *
	 * @param int $id The ID of the user to retrieve.
	 *
	 * @return mixed The retrieved user or a 404 response if not found.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function show(int $id): mixed {
		if (!User::exists(['id' => $id])) {
			return response(404, 'User(' . $id . ') not found!');
		}
		
		return User::get('*', null, ['id' => $id]) ?: response(404, 'User not found!');
	}
	
	/**
	 * Creates a new user.
	 *
	 * @return mixed The created user or a 400 response if the input is invalid.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function create(): mixed {
		$name = param('name');
		$userName = param('user_name');
		$password = param('password');
		$email = param('email');
		$ip = Request::ip();
		
		if (empty($name)) {
			return response(400, 'Invalid name');
		}
		
		if (empty($userName)) {
			return response(400, 'Invalid username');
		}
		
		if (empty($password)) {
			return response(400, 'Invalid password');
		}
		
		if (empty($email) || !isEmail($email)) {
			return response(400, 'Invalid email');
		}
		
		if (User::exists([
			'OR' => [
				'user_name' => $userName,
				'email' => $email,
			]
		])) {
			return response(400, 'Username or email already exists!');
		}
		
		$salt = getRandomString(16);
		$hashedPassword = md5($password . $salt);
		
		return User::insert([
			'name' => $name,
			'user_name' => $userName,
			'password' => $hashedPassword,
			'email' => $email,
			'last_login' => currentTime(), // TODO: Change it to last login time (When user logged in, update it)
			'last_ip' => $ip,
			'salt' => $salt
		]);
	}
	
	/**
	 * Deletes a user by its ID.
	 *
	 * @param int $id The ID of the user to delete.
	 *
	 * @return mixed The result of the delete operation.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function destroy(int $id): mixed {
		if (!User::exists(['id' => $id])) {
			return response(404, 'User(' . $id . ') not found!');
		}
		
		return User::delete(['id' => $id]);
	}
	
	/**
	 * Updates an existing user.
	 *
	 * @param int $id The ID of the user to update.
	 *
	 * @return mixed The result of the update operation.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function update(int $id): mixed {
		$user = User::get('*', null, ['id' => $id]);
		if (!$user) {
			return response(404, 'User(' . $id . ') not found!');
		}
		
		$salt = $user['salt'];
		$password = param('password');
		
		$updatedData = [
			'name' => param('name') ?? $user['name'],
			'user_name' => param('user_name') ?? $user['user_name']
		];
		if ($password && $user['password'] !== md5($password . $salt)) {
			$salt = getRandomString(16);
			$updatedData['salt'] = $salt;
			$updatedData['password'] = md5($password . $salt);
		}
		
		return User::update($updatedData, ['id' => $id]);
	}
}