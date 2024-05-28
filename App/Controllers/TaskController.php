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
		$taskData = Task::get('*', null, [
			'id' => $id,
			'created_by' => Auth::user('id')
		]);
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
		if (Task::delete([
			'id' => $id,
			'created_by' => Auth::user('id')
		])) {
			return response(200, 'Task(' . $id . ') removed successfully', null, true);
		}
		
		return response(404, 'Task(' . $id . ') not found!');
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
		$task = Task::get('*', null, ['AND' => [
			'id' => $id,
			'created_by' => Auth::user('id')
		]]);
		
		if (!$task) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		$status = param('status');
		$isCompleted = strtolower($status ?? '') === 'completed';
		$completedAtTime = currentTime();
		
		if (Task::update([
			'title' => param('title') ?? $task['title'],
			'description' => param('description') ?? $task['description'],
			'status' => $status ?? $task['status'],
			'completed_at' => $isCompleted ? $completedAtTime : $task['completed_at'],
			'updated_at' => currentTime()
		], ['id' => $id])) {
			$data = [];
			// Check if the task's status is completed, return completed time and if it's not, return creation time
			if ($isCompleted) {
				$data['completed_at'] = $completedAtTime;
			} else {
				$data['created_at'] = Task::get('created_at', null, ['id' => $id]);
			}
			
			return response(200, 'Task(' . $id . ') updated successfully', $data, true);
		}
		
		return response(400, 'Unable to update task(' . $id . ')!');
	}
}