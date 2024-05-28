<?php

namespace App\Models;

use App\Services\Auth;
use App\Exceptions\DBException;
use App\Exceptions\ModelException;

/**
 * task Model
 *
 * This model represents the tasks of the application.
 */
class Task extends Model {
	/**
	 * Get the name of the database table associated with the task model.
	 *
	 * @return string
	 */
	public static function tableName(): string {
		return 'tasks';
	}
	
	/**
	 * Get the name of the primary key column for the task model.
	 *
	 * @return string|null
	 */
	public static function primaryKey(): string|null {
		return 'id';
	}
	
	/**
	 * Get task based on user's authentication credentials
	 *
	 * @param int $id The ID of the task to update.
	 * @param string|array $col The column(s) to get.
	 *
	 * @return array|null Array with task's data or null
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public static function getAuthTask(int $id, string|array $col = '*'): mixed {
		return static::get($col, null, ['AND' => [
			'id' => $id,
			'created_by' => Auth::user('id')
		]]) ?: null;
	}
}