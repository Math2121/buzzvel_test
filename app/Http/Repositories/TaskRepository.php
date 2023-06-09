<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskRepository implements TaskRepositoryInterface
{

    public function __construct(private Task $task)
    {
    }
    public function saveATask(array $data)
    {
        DB::beginTransaction();
        try {
            $task = $this->task->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'file' => $data['file'],
                'dates' => $data['dates'],
                'user' => $data['user'],
            ]);
            DB::commit();
            return $task;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
    public function editOneTask(array $data, $id)
    {
        $task = $this->task->find($id);
        DB::beginTransaction();
        try {
            $task->update($data);
            DB::commit();
            return $task;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
    public function tasksList()
    {
        return $this->task->all();
    }
    public function getTask($id)
    {
        return $this->task->find($id);
    }
    public function deleteOneTask(int $id)
    {

        try {
            DB::beginTransaction();
            $task = $this->task->find($id);
            $task->dates = Carbon::now()->format('Y-m-d');
            $task->save();
            $task->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
}
