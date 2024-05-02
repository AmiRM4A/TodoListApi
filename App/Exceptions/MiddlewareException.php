<?php

namespace App\Exceptions;

/**
 * MiddlewareException
 *
 * This exception is thrown when an error occurs during the execution of middleware in the application.
 * Middleware is a layer of code that sits between the request and the application logic, allowing for various operations
 * such as authentication, logging, or other pre-processing tasks.
 *
 * This exception extends the base Exception class provided by PHP, allowing for custom error handling and messaging
 * specific to middleware-related issues.
 *
 * Example usage:
 *
 * throw new MiddlewareException('Authentication failed: Invalid credentials.', 401);
 */
class MiddlewareException extends \Exception {
}