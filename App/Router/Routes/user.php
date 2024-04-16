<?php

use App\Router\Route;

Route::get('get-users', 'UserController@index'); // Get all users
Route::get('get-user/{id}', 'UserController@show'); // Get a specific user by id
Route::post('create-user', 'UserController@create'); // Create new user
Route::delete('remove-user/{id}', 'UserController@destroy'); // Delete an existing user
Route::put('update-user/{id}', 'UserController@update'); // Update an existing user