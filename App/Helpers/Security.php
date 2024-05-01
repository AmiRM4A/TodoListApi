<?php

namespace App\Helpers;

/**
 * Class Security
 *
 * Provides some security methods.
 */
class Security {
	/**
	 * Clean an array based on specified filters.
	 *
	 * This function is used to sanitize an array of data according to specified filters.
	 * It also provides an option to exclude certain keys from the cleaned data.
	 *
	 * @param array $array The array to be cleaned.
	 * @param int|array $filters The filter(s) to apply to the data. If no filter is specified,
	 *                           FILTER_UNSAFE_RAW will be used as the default filter.
	 *                           Multiple filters can be specified as an array.
	 * @param array $exclude_keys An array of keys to be excluded from the cleaned data.
	 *
	 * @return array|false The cleaned data as an array, or false if filtering fails.
	 *
	 * Example usage:
	 *
	 * $cleanedData = self::cleanArray(['name' => 'John <script>'], [FILTER_SANITIZE_STRING]);
	 * $cleanedData = self::cleanArray(['email' => 'test@example.com', 'age' => 25], FILTER_UNSAFE_RAW, ['age']);
	 */
	public static function cleanArray(array $array, int|array $filters = [], array $exclude_keys = []): array|false {
		$filters = empty($filters) ? FILTER_UNSAFE_RAW : $filters;
		
		$cleaned_data = filter_var_array($array, $filters, true);
		
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