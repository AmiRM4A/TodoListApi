<?php

namespace App\Exceptions;

/**
 * DBException
 *
 * This exception is thrown when an error occurs related to database operations within the application.
 * It encompasses various types of database-related errors, such as connection issues, query errors, data integrity violations,
 * and other database-specific exceptions.
 *
 * This exception extends the base Exception class provided by PHP, allowing for custom error handling and messaging
 * specific to database-related issues.
 *
 * Example usage:
 *
 * try {
 *     $result = $db->query("SELECT * FROM users WHERE id = ?", [$userId]);
 * } catch (\PDOException $e) {
 *     throw new DBException("Error executing database query: " . $e->getMessage(), $e->getCode(), $e);
 * }
 */
class DBException extends \Exception {
}