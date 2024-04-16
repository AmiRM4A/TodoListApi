<?php

namespace App\Models;

/**
 * User Model
 *
 * This model represents the users of the application.
 */
class User extends Model
{
	/**
	 * Get the name of the database table associated with the User model.
	 *
	 * @return string
	 */
	public static function tableName(): string
	{
		return 'users';
	}
	
	/**
	 * Get the name of the primary key column for the User model.
	 *
	 * @return string|null
	 */
	public static function primaryKey(): string|null
	{
		return 'id';
	}
}