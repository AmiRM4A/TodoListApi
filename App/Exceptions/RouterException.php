<?php

namespace App\Exceptions;

/**
 * RouterException
 *
 * This exception is thrown when there is an issue related to the application's routing system.
 * It can be thrown when a requested route is not defined or when there is an error in the routing configuration.
 *
 * This exception extends the base Exception class provided by PHP, allowing for custom error handling and messaging.
 *
 * Example usage:
 *
 * throw new RouterException('The requested route was not found.', 404);
 */
class RouterException extends \Exception {
}