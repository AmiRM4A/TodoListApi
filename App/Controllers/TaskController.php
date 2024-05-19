<?php

namespace App\Controllers;

use App\Models\Task;
use App\Services\Auth;
use App\Exceptions\DBException;
use App\Exceptions\ModelException;

/**
 * TaskController class
 *
 * Handles CRUD operations for tasks.
 */
class TaskController {
	/**
	 * Retrieves all tasks.
	 *
	 * @return mixed The retrieved tasks.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function index(): mixed {
		return Task::select('*', null, ['created_by' => Auth::user('id')]);
	}
	
	/**
	 * Retrieves a specific task by its ID.
	 *
	 * @param int $id The ID of the task to retrieve.
	 *
	 * @return mixed The retrieved task or a 404 response if not found.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function show(int $id): mixed {
		$userId = Auth::user('id');
		
		if (!Task::exists(['AND' => [
			'id' => $id,
			'created_by' => $userId
		]])) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		return Task::get('*', null, ['id' => $id]) ?: response(404, 'Task not found!');
	}
	
	/**
	 * Creates a new task.
	 *
	 * @return mixed The created task or a 400 response if the title is invalid.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function create(): mixed {
		$title = param('title');
		$description = param('description', '');
		$status = param('status', 'pending');
		
		if (empty($title)) {
			return response(400, 'Invalid title');
		}
		
		return Task::insert([
			'title' => $title,
			'description' => $description,
			'status' => $status,
			'created_by' => Auth::user('id'),
			'updated_at' => currentTime()
		]);
	}
	
	/**
	 * Deletes a task by its ID.
	 *
	 * @param int $id The ID of the task to delete.
	 *
	 * @return mixed The result of the delete operation.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function destroy(int $id): mixed {
		$userId = Auth::user('id');
		
		if (!Task::exists(['AND' => [
			'id' => $id,
			'created_by' => $userId
		]])) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		return Task::delete(['id' => $id]);
	}
	
	/**
	 * Updates an existing task.
	 *
	 * @param int $id The ID of the task to update.
	 *
	 * @return mixed The result of the update operation.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function update(int $id): mixed {
		$userId = Auth::user('id');
		$task = Task::get('*', null, ['AND' => [
			'id' => $id,
			'created_by' => $userId
		]]);
		
		if (!$task) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		$updatedData = [
			'title' => param('title') ?? $task['title'],
			'description' => param('description') ?? $task['description'],
			'status' => param('status') ?? $task['status'],
			'completed_at' => param('completed_at') ?? $task['completed_at'],
			'updated_at' => currentTime()
		];
		
		return Task::update($updatedData, ['id' => $id]);
	}
}