<?php

namespace App\Models;

interface ModelInterface {
	public static function tableName(): string;
	public static function primaryKey(): string|null;
	public static function get(string|array $column, ?array $join, ?array $where = null): mixed;
	public static function select(string|array $column, ?array $join = null, ?array $where = null): mixed;
	public static function insert(array $data): int|bool|null;
	public static function update(array $data, array $where): bool;
	public static function delete(array $where): bool;
	public static function exists(array $where): bool;
}
