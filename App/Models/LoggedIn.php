<?php

namespace App\Models;

/**
 * LoggedIn Model
 *
 * The LoggedIn class is a subclass of the Model class and represents the "logged_in" table in the database.
 */
class LoggedIn extends Model {
	
	/**
	 * Returns the name of the table associated with this model.
	 *
	 * @return string The name of the table.
	 */
	public static function tableName(): string {
		return 'logged_in';
	}
	
	/**
	 * Returns the name of the primary key column for this table.
	 *
	 * @return string|null The name of the primary key column, or null if no primary key is defined.
	 */
	public static function primaryKey(): string|null {
		return 'id';
	}
}