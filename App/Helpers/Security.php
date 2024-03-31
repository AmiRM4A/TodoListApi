<?php

namespace App\Helpers;

use InvalidArgumentException;

class Security {
	public static function cleanInputData($input_array, $filters = [], $exclude_keys = []): false|array|null {
		if (!is_array($input_array)) {
			throw new InvalidArgumentException("Input must be an array");
		}
		
		$filters = empty($filters) ? FILTER_UNSAFE_RAW : $filters;
		
		$cleaned_data = filter_var_array($input_array, $filters, true);
		
		if ($cleaned_data === false) {
			return false;
		}
		
		foreach ($exclude_keys as $key) {
			if (array_key_exists($key, $cleaned_data)) {
				unset($cleaned_data[$key]);
			}
		}
		
		return $cleaned_data;
	}
}