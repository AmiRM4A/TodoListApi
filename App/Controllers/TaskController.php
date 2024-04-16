<?php

namespace App\Controllers;

use App\Models\Task;
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
	 * @throws ModelException
	 * @throws DBException
	 */
	public function index(): mixed {
		return Task::select('*');
	}
	
	/**
	 * Retrieves a specific task by its ID.
	 *
	 * @param int $id The ID of the task to retrieve.
	 *
	 * @return mixed The retrieved task or a 404 response if not found.
	 * @throws ModelException
	 * @throws DBException
	 */
	public function show(int $id): mixed {
		if (!Task::exists(['id' => $id])) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		return Task::get('*', ['id' => $id]) ?: response(404, 'Task not found!');
	}
	
	/**
	 * Creates a new task.
	 *
	 * @return mixed The created task or a 400 response if the title is invalid.
	 * @throws ModelException
	 * @throws DBException
	 */
	public function create(): mixed {
		$title = sanitizeStr(bodyParam('title'));
		$description = sanitizeStr(bodyParam('description', ''));
		$status = sanitizeStr(bodyParam('status', 'Uncompleted'));
		$createdBy = bodyParam('created_by', 1);
		$updatedAt = currentTime();
		
		if (empty($title)) {
			return response(400, 'Invalid title');
		}
		
		return Task::insert([
			'title' => $title,
			'description' => $description,
			'status' => $status,
			'created_by' => $createdBy,
			'updated_at' => $updatedAt
		]);
	}
	
	/**
	 * Deletes a task by its ID.
	 *
	 * @param int $id The ID of the task to delete.
	 *
	 * @return mixed The result of the delete operation.
	 * @throws ModelException
	 * @throws DBException
	 */
	public function destroy(int $id): mixed {
		if (!Task::exists(['id' => $id])) {
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
	 * @throws ModelException
	 * @throws DBException
	 */
	public function update(int $id): mixed {
		$task = Task::get('*', ['id' => $id]);
		
		if (!$task) {
			return response(404, 'Task(' . $id . ') not found!');
		}
		
		$updatedData = [];
		$title = sanitizeStr(bodyParam('title'));
		$description = sanitizeStr(bodyParam('description'));
		$status = sanitizeStr(bodyParam('status'));
		
		if ($title && $task['title'] !== $title) {
			$updatedData['title'] = $title;
		}
		
		if ($description && $task['description'] !== $description) {
			$updatedData['description'] = $description;
		}
		
		if ($status && $task['status'] !== $status) {
			$updatedData['status'] = $status;
		}
		
		if (!empty($updatedData)) {
			$updatedData['updated_at'] = currentTime();
			return Task::update($updatedData, ['id' => $id]);
		}
		
		return response(200, 'Nothing to update');
	}
}