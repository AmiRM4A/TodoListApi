<?php

namespace App\Models;

use \Exception;

/**
 * Class BaseModel
 *
 * Abstract base model class providing common database operations.
 */
abstract class BaseModel implements BaseModelInterface {
	/**
	 * Retrieve data from the database.
	 *
	 * @param string|array $column The column(s) to retrieve.
	 * @param array|null $where The WHERE clause conditions.
	 *
	 * @return array|null The retrieved data or null on failure.
	 */
	public static function get(string|array $column, $where = null): array|null {
		if (empty($column)) {
			return null;
		}
		
		try {
			return DB::q()->get(static::tableName(), $column, $where);
		} catch (Exception) {
			return null;
		}
	}
	
	/**
	 * Select data from the database.
	 *
	 * @param string|array $column The column(s) to select.
	 * @param array|null $where The WHERE clause conditions.
	 *
	 * @return array|null The selected data or null on failure.
	 */
	public static function select(string|array $column, array $where = null): array|null {
		if (empty($column)) {
			return null;
		}
		
		try {
			return DB::q()->select(static::tableName(), $column, $where);
		} catch (Exception) {
			return null;
		}
	}
	
	/**
	 * Insert data into the database.
	 *
	 * @param array $data The data to insert.
	 *
	 * @return int|bool|null The inserted row ID, false on failure, or null for empty data.
	 */
	public static function insert(array $data): int|bool|null {
		if (empty($data)) {
			return null;
		}
		
		try {
			DB::q()->insert(static::tableName(), $data, static::primaryKey());
			return DB::q()->id();
		} catch (Exception) {
			return false;
		}
	}
	
	/**
	 * Update data in the database.
	 *
	 * @param array $data The data to update.
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool The success status of the update operation.
	 */
	public static function update(array $data, array $where): bool {
		if (empty($data) || empty($where)) {
			return false;
		}
		
		try {
			DB::q()->update(static::tableName(), $data, $where);
			return true;
		} catch (Exception) {
			return false;
		}
	}
	
	/**
	 * Delete data from the database.
	 *
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool The success status of the delete operation.
	 */
	public static function delete(array $where): bool {
		if (empty($where)) {
			return false;
		}
		
		try {
			DB::q()->delete(static::tableName(), $where);
			return true;
		} catch (Exception) {
			return false;
		}
	}
	
	/**
	 * Check if data exists in the database.
	 *
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool The existence status of the data.
	 */
	public static function exists(array $where): bool {
		if (empty($where)) {
			return false;
		}
		
		try {
			return DB::q()->has(static::tableName(), $where);
		} catch (Exception) {
			return false;
		}
	}
}