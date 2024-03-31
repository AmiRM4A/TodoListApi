<?php

namespace App\Core;

use App\Helpers\Security;

class Request {
	public static function method(): string {
		return $_SERVER['REQUEST_METHOD'];
	}
	
	public static function fullUri(): string {
		return $_SERVER['REQUEST_URI'];
	}
	
	public static function uri(): string {
		$url = strtok(self::fullUri(), '?');
		if ($url === '/') {
			return $url;
		}
		return trim($url, '/');
	}
	
	public static function host(): string {
		return $_SERVER['HTTP_HOST'];
	}
	
	public static function post(): array|bool {
		return Security::cleanInputData($_POST, FILTER_UNSAFE_RAW);
	}
	
	public static function get(): array|bool {
		return Security::cleanInputData($_GET, FILTER_UNSAFE_RAW);
	}
	
	public static function params(): array {
		return array_merge(self::get(), self::post());
	}
	
	public static function bodyParams(): array {
		parse_str(file_get_contents('php://input'), $body);
		return $body;
	}
	
	public static function param($key, $default = null): mixed {
		return self::params()[$key] ?? $default;
	}
	
	public static function bodyParam($key, $default = null): mixed {
		return self::bodyParams()[$key] ?? $default;
	}
	
	public static function ip(): string {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //Ip From Share Internet
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //Ip Pass From Proxy
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		
		return $_SERVER['REMOTE_ADDR'];
	}
	
	public static function agent(): string {
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	public static function fullParams(): array {
		return array_merge(self::params(), self::bodyParams());
	}
	
	public function __get($name) {
		$args = self::fullParams();
		return $args[$name] ?? null;
	}
}
