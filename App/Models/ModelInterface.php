<?php

namespace App\Models;

/**
 * Interface ModelInterface
 *
 * This interface defines methods for interacting with a database table.
 */
interface ModelInterface {
	
	/**
	 * Get the table name associated with the model.
	 *
	 * @return string The table name.
	 */
	public static function tableName(): string;
	
	/**
	 * Get the primary key for the model.
	 *
	 * @return string|null The primary key column name, or null if not set.
	 */
	public static function primaryKey(): ?string;
	
	/**
	 * Retrieve data from the table based on specified criteria.
	 *
	 * @param string|array $column The columns to retrieve.
	 * @param array|null $join Optional join conditions.
	 * @param array|null $where Optional WHERE clause conditions.
	 *
	 * @return mixed The retrieved data.
	 */
	public static function get(string|array $column, ?array $join, ?array $where = null): mixed;
	
	/**
	 * Select data from the table based on specified criteria.
	 *
	 * @param string|array $column The columns to select.
	 * @param array|null $join Optional join conditions.
	 * @param array|null $where Optional WHERE clause conditions.
	 *
	 * @return mixed The selected data.
	 */
	public static function select(string|array $column, ?array $join = null, ?array $where = null): mixed;
	
	/**
	 * Insert a new record into the table.
	 *
	 * @param array $data The data to insert.
	 *
	 * @return int|bool|null The ID of the inserted record, or false on failure.
	 */
	public static function insert(array $data): int|bool|null;
	
	/**
	 * Update records in the table based on specified criteria.
	 *
	 * @param array $data The data to update.
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool True on success, false on failure.
	 */
	public static function update(array $data, array $where): bool;
	
	/**
	 * Delete records from the table based on specified criteria.
	 *
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool True on success, false on failure.
	 */
	public static function delete(array $where): bool;
	
	/**
	 * Check if records exist in the table based on specified criteria.
	 *
	 * @param array $where The WHERE clause conditions.
	 *
	 * @return bool True if records exist, false otherwise.
	 */
	public static function exists(array $where): bool;
}
