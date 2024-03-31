<?php

namespace App\Helpers;

class Str {
	public static function toUpperCase(array|string $data): array|string {
		if (is_string($data)) {
			return strtoupper($data);
		} else if (is_array($data)) {
			return array_map(function ($value) {
				return self::toUpperCase($value);
			}, $data);
		} else {
			return $data;
		}
	}
	
	public static function toLowerCase(array|string $data): array|string {
		if (is_string($data)) {
			return strtolower($data);
		} else if (is_array($data)) {
			return array_map(function ($value) {
				return self::toLowerCase($value);
			}, $data);
		} else {
			return $data;
		}
	}
}
