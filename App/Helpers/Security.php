<?php

namespace App\Helpers;

use InvalidArgumentException;

/**
 * Class Security
 *
 * Provides methods for sanitizing input data.
 */
class Security {
	/**
	 * Clean input data based on specified filters.
	 *
	 * @param array $input_array The input data to be sanitized.
	 * @param int|array $filters The filter to apply to the input data. Default is FILTER_UNSAFE_RAW.
	 * @param array $exclude_keys Keys to exclude from the cleaned data.
	 *
	 * @return array|false|null The cleaned input data, or false if filtering fails.
	 * @throws InvalidArgumentException If the input is not an array.
	 */
	public static function cleanInputData(array $input_array, int|array $filters = [], array $exclude_keys = []): false|array|null {
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