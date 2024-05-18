<?php

use App\Router\ApiRoute;

ApiRoute::get('get-tasks', 'TaskController@index')->auth(); // Get all tasks
ApiRoute::get('get-task/{id}', 'TaskController@show')->auth(); // Get a specific task by id
ApiRoute::post('create-task', 'TaskController@create')->auth(); // Create new task
ApiRoute::delete('remove-task/{id}', 'TaskController@destroy')->auth(); // Delete an existing task
ApiRoute::put('update-task/{id}', 'TaskController@update')->auth(); // Update an existing task