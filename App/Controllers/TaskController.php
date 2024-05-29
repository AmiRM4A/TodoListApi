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
		$tasksList = Task::select('*', null,
			['created_by' => Auth::user('id')]
		);
		return response(200, 'Tasks list retrieved successfully', $tasksList ?? [], true);
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
		$taskData = Task::getAuthTask($id);
		if ($taskData) {
			return response(200, 'Task(' . $id . ') retrieved successfully', $taskData, true);
		}
		
		return response(404, 'Task(' . $id . ') not found!');
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
		
		if (!$title) {
			return response(400, 'Invalid title!');
		}
		
		$lastId = Task::insert([
			'title' => $title,
			'description' => param('description', ''),
			'status' => param('status', 'pending'),
			'created_by' => Auth::user('id'),
			'updated_at' => currentTime()
		]);
		
		if (!$lastId) {
			return response(500, 'Unable to create your task!');
		}
		
		$createdAt = Task::get('created_at', null, ['id' => $lastId]);
		
		if (!$createdAt) {
			return response(500, 'Unable to retrieve task\'s creation date!');
		}
		
		return response(200, 'Task created successfully', [
			'id' => $lastId,
			'created_at' => $createdAt
		], true);
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
		$taskId = Task::getAuthTask($id, 'id');
		
		if (!$taskId) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		if (Task::delete([
			'id' => $id,
			'created_by' => Auth::user('id')
		])) {
			return response(200, 'Task(' . $id . ') removed successfully', null, true);
		}
		
		return response(500, 'Unable to update task(' . $id . ')!');
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
		$task = Task::getAuthTask($id);
		
		if (!$task) {
			return response(404, 'Task(' . $id . ') not found!');
		}

		if (Task::update([
			'title' => param('title') ?? $task['title'],
			'description' => param('description') ?? $task['description'],
			'status' => param('status') ?? $task['status'],
			'updated_at' => currentTime()
		], ['id' => $id])) {
			return response(200, 'Task(' . $id . ') updated successfully', null, true);
		}
		
		return response(500, 'Unable to update task(' . $id . ')!');
	}
	
	/**
	 * Marking a task as completed (done)
	 *
	 * @param int $id The ID of the task to update.
	 *
	 * @return mixed The result of the operation.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function complete(int $id): mixed {
		$taskId = Task::getAuthTask($id, 'id');
		
		if (!$taskId) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		$completedAtTime = currentTime();
		
		if (Task::update([
			'completed_at' => $completedAtTime,
			'status' => 'completed'
		], [
			'id' => $taskId
		])){
			return response(200, 'Task(' . $id . ') completed successfully', [
				'completed_at' => $completedAtTime
			], true);
		}
		
		return response(500, 'Unable to complete task(' . $id . ')');
	}
	
	/**
	 * Marking a task as uncompleted (not done)
	 *
	 * @param int $id The ID of the task to update.
	 *
	 * @return mixed The result of the operation.
	 *
	 * @throws ModelException If there is an error with the LoggedIn model.
	 * @throws DBException If there is an error retrieving data from the database.
	 */
	public function unComplete(int $id): mixed {
		$taskData = Task::getAuthTask($id, ['id', 'created_at']);
		
		if (!$taskData) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		if (Task::update([
			'completed_at' => null,
			'status' => 'pending'
		], [
			'id' => $taskData['id']
		])) {
			return response(200, 'Task(' . $id . ') completed successfully', [
				'created_at' => $taskData['created_at']
			], true);
		}
		
		return response(500, 'Unable to uncomplete task(' . $id . ')');
	}
}