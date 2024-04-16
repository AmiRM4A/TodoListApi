<?php

use App\Router\Route;

Route::get('get-tasks', 'TaskController@index'); // Get all tasks
Route::get('get-task/{id}', 'TaskController@show'); // Get a specific task by id
Route::post('create-task', 'TaskController@create'); // Create new task
Route::delete('remove-task/{id}', 'TaskController@destroy'); // Delete an existing task
Route::put('update-task/{id}', 'TaskController@update'); // Update an existing task