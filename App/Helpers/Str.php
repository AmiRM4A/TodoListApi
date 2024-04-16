<?php

namespace App\Helpers;

/**
 * Class Str
 *
 * Provides string manipulation methods.
 */
class Str {
	/**
	 * Convert a string or an array of strings to uppercase.
	 *
	 * @param string|array $data The string or array of strings to convert.
	 *
	 * @return string|array The resulting string or array with all letters converted to uppercase.
	 */
	public static function toUpperCase(array|string $data): array|string {
		if (is_string($data)) {
			return strtoupper($data);
		}
		
		if (is_array($data)) {
			return array_map(function ($value) {
				return self::toUpperCase($value);
			}, $data);
		}
		
		return $data;
	}
	
	/**
	 * Convert a string or an array of strings to lowercase.
	 *
	 * @param string|array $data The string or array of strings to convert.
	 *
	 * @return string|array The resulting string or array with all letters converted to lowercase.
	 */
	public static function toLowerCase(array|string $data): array|string {
		if (is_string($data)) {
			return strtolower($data);
		}
		
		if (is_array($data)) {
			return array_map(function ($value) {
				return self::toLowerCase($value);
			}, $data);
		}
		
		return $data;
	}
}