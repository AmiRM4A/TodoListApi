<?php

namespace App\Models;

use \Exception;

abstract class BaseModel implements BaseModelInterface {
	public static function get(string|array $column, $where = null): array|null {
		if (empty($column)) return null;
		try {
			return DB::q()->get(static::tableName(), $column, $where);
		} catch (Exception) {
			return null;
		}
	}

	public static function select(string|array $column, array $where = null): array|null {
		if (empty($column)) return null;
		try {
			return DB::q()->select(static::tableName(), $column, $where);
		} catch (Exception) {
			return null;
		}
	}

	public static function insert(array $data): int|bool|null {
		if (empty($data)) return null;
		try {
			DB::q()->insert(static::tableName(), $data, static::primaryKey());
			return DB::q()->id();
		} catch (Exception) {
			return false;
		}
	}

	public static function update(array $data, array $where): bool {
		if (empty($data) || empty($where)) return false;
		try {
			DB::q()->update(static::tableName(), $data, $where);
			return true;
		} catch (Exception) {
			return false;
		}
	}

	public static function delete(array $where): bool {
		if (empty($where)) return false;
		try {
			DB::q()->delete(static::tableName(), $where);
			return true;
		} catch (Exception) {
			return false;
		}
	}

	public static function exists(array $where): bool {
		if (empty($where)) return false;
		try {
			return DB::q()->has(static::tableName(), $where);
		} catch (Exception) {
			return false;
		}
	}
}
