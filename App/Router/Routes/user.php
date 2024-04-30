<?php

use App\Router\ApiRoute;

ApiRoute::get('get-users', 'UserController@index'); // Get all users
ApiRoute::get('get-user/{id}', 'UserController@show'); // Get a specific user by id
ApiRoute::post('create-user', 'UserController@create'); // Create new user
ApiRoute::delete('remove-user/{id}', 'UserController@destroy'); // Delete an existing user
ApiRoute::put('update-user/{id}', 'UserController@update'); // Update an existing user