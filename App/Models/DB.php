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
					'type' => $_ENV['DB_TYPE'],
					'host' => $_ENV['HOST'],
					'database' => $_ENV['DB_NAME'],
					'username' => $_ENV['DB_USER'],
					'password' => $_ENV['DB_PASS'],
					'charset' => 'utf8mb4',
					'collation' => 'utf8mb4_general_ci',
					'port' => $_ENV['DB_PORT'],
					'logging' => $_ENV['MEDOO_LOG']
				]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				self::$connection = null;
			}
		}
	}
}
