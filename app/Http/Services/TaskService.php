<?php

namespace App\Http\Services;


use App\Http\Interfaces\TaskRepositoryInterface;
use App\Http\Interfaces\TaskServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class TaskService implements TaskServiceInterface
{

    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }
    public function createTask(array $data)
    {

        try {

            $randomName = uniqid() . '.' . $data['file']->getClientOriginalExtension();

            Storage::disk('local')->put('/tmp/' . $randomName, file_get_contents($data['file']));



            $data['file'] = $randomName;

            $task = $this->taskRepository->saveATask($data);


            return [
                "data" => $task,
                "status_code" => Response::HTTP_CREATED
            ];
        } catch (\Exception $e) {
            return [
                "data" => $e->getMessage(),
                "status_code" => Response::HTTP_BAD_GATEWAY
            ];
        }
    }
    public function editTask(array $data, $id)
    {
        $task = $this->taskRepository->getTask($id);
        if (!$task) {
            return [
                "data" => "Not found Task",
                "status_code" => Response::HTTP_NOT_FOUND
            ];
        }
        $task = $this->taskRepository->editOneTask($data, (int) $id);

        return [
            "data" =>   $task,
            "status_code" => Response::HTTP_ACCEPTED
        ];
    }
    public function recoverTasks()
    {
        return $this->taskRepository->tasksList();
    }
    public function recoverOneTask($id)
    {
        $task = $this->taskRepository->getTask($id);
        return [
            "data" => $task,
            "status_code" => Response::HTTP_ACCEPTED
        ];
    }
    public function deleteTask(int $id)
    {
        $task = $this->taskRepository->getTask($id);
        if (!$task) {
            return [
                "data" => "Not found Task",
            ];
        }

        $this->taskRepository->deleteOneTask((int) $id);
        return true;
    }
}
