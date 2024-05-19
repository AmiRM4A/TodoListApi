<?php

use App\Router\ApiRoute;

ApiRoute::get('get-users', 'UserController@index'); // Get all users, requires authentication
ApiRoute::get('get-user/{id}', 'UserController@show'); // Get a specific user by id, requires authentication
ApiRoute::post('create-user', 'UserController@create'); // Create new user, requires authentication
ApiRoute::delete('remove-user/{id}', 'UserController@destroy'); // Delete an existing user, requires authentication
ApiRoute::put('update-user/{id}', 'UserController@update'); // Update an existing user, requires authentication