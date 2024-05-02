<?php

use App\Router\ApiRoute;

ApiRoute::get('get-tasks', 'TaskController@index'); // Get all tasks
ApiRoute::get('get-task/{id}', 'TaskController@show'); // Get a specific task by id
ApiRoute::post('create-task', 'TaskController@create'); // Create new task
ApiRoute::delete('remove-task/{id}', 'TaskController@destroy'); // Delete an existing task
ApiRoute::put('update-task/{id}', 'TaskController@update'); // Update an existing task