<?php

namespace App\Helpers;

class Str {
	public static function toUpperCase(array|string $data): array|string {
		if (is_string($data)) {
			return strtoupper($data);
		}
		$upper_data = [];
		foreach ($data as $value) {
			if (!is_string($value)) {
				continue;
			}
			$upper_data[] = strtoupper($value);
		}
		return $upper_data;
	}
	
	public static function toLowerCase(array|string $data): array|string {
		if (is_string($data)) {
			return strtolower($data);
		}
		$upper_data = [];
		foreach ($data as $value) {
			if (!is_string($value)) {
				continue;
			}
			$upper_data[] = strtolower($value);
		}
		return $upper_data;
	}
}
