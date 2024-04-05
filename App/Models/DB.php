<?php

namespace App\Models;

use Medoo\Medoo;

/**
 * Class DB
 *
 * Provides a database connection and query execution.
 */
class DB {
	/**
	 * The database connection instance.
	 *
	 * @var Medoo|null The Medoo database connection instance.
	 */
	private static ?Medoo $connection = null;
	
	/**
	 * Get the Medoo database query instance.
	 *
	 * @return Medoo The Medoo database query instance.
	 */
	public static function q(): Medoo {
		self::connect();
		return self::$connection;
	}
	
	/**
	 * Establish a database connection if not already connected.
	 *
	 * @return void
	 */
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