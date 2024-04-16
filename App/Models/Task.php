<?php

namespace App\Models;

/**
 * task Model
 *
 * This model represents the tasks of the application.
 */
class Task extends Model
{
	/**
	 * Get the name of the database table associated with the task model.
	 *
	 * @return string
	 */
	public static function tableName(): string
	{
		return 'tasks';
	}
	
	/**
	 * Get the name of the primary key column for the task model.
	 *
	 * @return string|null
	 */
	public static function primaryKey(): string|null
	{
		return 'id';
	}
}