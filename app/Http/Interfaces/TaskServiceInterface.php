<?php


namespace App\Http\Interfaces;
interface TaskServiceInterface
{
	public function createTask(array $data);
    public function editTask(array $data, $id);
    public function recoverTasks();
    public function recoverOneTask(int $id);
    public function deleteTask(int $id);
}
