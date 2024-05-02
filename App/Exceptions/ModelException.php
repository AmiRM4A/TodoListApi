<?php

namespace App\Exceptions;

/**
 * ModelException
 *
 * This exception is thrown when an error occurs related to the application's data models.
 * Models typically represent the data structure and business logic of the application's entities,
 * such as users, products, orders, etc.
 *
 * This exception extends the base Exception class provided by PHP, allowing for custom error handling and messaging
 * specific to model-related issues.
 *
 * Example usage:
 *
 * throw new ModelException('Unable to save user data: Validation failed.', 422);
 */
class ModelException extends \Exception {
}