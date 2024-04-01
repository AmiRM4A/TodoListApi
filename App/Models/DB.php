<?php

namespace App\Models;

use Medoo\Medoo;

class DB {
	private static ?Medoo $connection = null;

	public static function q(): Medoo {
		self::connect();
		return self::$connection;
	}

	private static function connect(): void {
		if (is_null(static::$connection)) {
			try {
				self::$connection = new Medoo([
					'type' => DB_TYPE,
					'host' => DB_HOST,
					'database' => DB_NAME,
					'username' => DB_USER,
					'password' => DB_PASS,
					'charset' => 'utf8mb4',
					'collation' => 'utf8mb4_general_ci',
					'port' => DB_PORT,
					'logging' => MEDOO_LOG
				]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				self::$connection = null;
			}
		}
	}
}
