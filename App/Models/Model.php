<?php

namespace App\Models;

use Throwable;
use App\Exceptions\DBException;
use App\Exceptions\ModelException;

/**
 * Class Model
 *
 * Abstract base model class providing common database operations.
 */
abstract class Model implements ModelInterface {
	/**
	 * Retrieve data from the database.
	 *
	 * @param string|array $column The column(s) to retrieve.
	 * @param array|null $where The WHERE clause conditions.
	 *
	 * @return array|null The retrieved data or null on failure.
	 * @throws ModelException
	 * @throws DBException
	 */
	public static function get(string|array $column, $where = null): array|null {
		if (empty($column)) {
			return null;
		}
		
		try {
			return DB::q()->get(static::tableName(), $column, $where);
		} catch (DBException $e) {
			throw $e;
		} catch (Throwable $e) {
			throw new ModelException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Select data from the database.
	 *
	 * @param string|array $column The column(s) to select.
	 * @param array|null $where The WHERE clause conditions.
	 *
	 * @return array|null The selected data or null on failure.
	 * @throws DBException
	 * @throws ModelException
	 */
	public static function select(string|array $column, array $where = null): array|null {
		if (empty($column)) {
			return null;
		}
		
		try {
			return DB::q()->select(static::tableName(), $column, $where);
		} catch (DBException $e) {
			throw $e;
		} catch (Throwable $e) {
			throw new ModelException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Insert data into the database.
	 *
	 * @param array $data The data to insert.
	 *
	 * @return int|bool|null The inserted row ID, false on failure, or null for empty data.
	 * @throws ModelException
	 * @throws DBException
	 */
	public static function insert(array $data): int|bool|null {
		if (empty($data)) {
			return null;
		}
		
		try {
			$db = DB::q();
			$db->insert(static::tableName(), $data, static::primaryKey());
			return $db->id();
		} catch (DBException $e) {
			throw $e;
		} catch (Throwable $e) {
			throw new ModelException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Update data in the database.
	 *
	 * @param array $data The data to update.
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool The success status of the update operation.
	 * @throws DBException
	 * @throws ModelException
	 */
	public static function update(array $data, array $where): bool {
		if (empty($data) || empty($where)) {
			return false;
		}
		
		try {
			DB::q()->update(static::tableName(), $data, $where);
			return true;
		} catch (DBException $e) {
			throw $e;
		} catch (Throwable $e) {
			throw new ModelException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Delete data from the database.
	 *
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool The success status of the delete operation.
	 * @throws DBException
	 * @throws ModelException
	 */
	public static function delete(array $where): bool {
		if (empty($where)) {
			return false;
		}
		
		try {
			DB::q()->delete(static::tableName(), $where);
			return true;
		} catch (DBException $e) {
			throw $e;
		} catch (Throwable $e) {
			throw new ModelException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Check if data exists in the database.
	 *
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool The existence status of the data.
	 * @throws DBException
	 * @throws ModelException
	 */
	public static function exists(array $where): bool {
		if (empty($where)) {
			return false;
		}
		
		try {
			return DB::q()->has(static::tableName(), $where);
		} catch (DBException $e) {
			throw $e;
		} catch (Throwable $e) {
			throw new ModelException($e->getMessage(), $e->getCode());
		}
	}
}