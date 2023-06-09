<?php


namespace App\Http\Interfaces;
interface TaskRepositoryInterface
{
	public function saveATask(array $data);
    public function editOneTask(array $data, int $id);
    public function getTask($id);
    public function tasksList();
    public function deleteOneTask(int $id);
}
