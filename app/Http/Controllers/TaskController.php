<?php

namespace App\Http\Controllers;


use App\Http\Interfaces\TaskServiceInterface;

use App\Http\Requests\CreateTaskRequest;

use App\Http\Requests\EditTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    //

    public function __construct(private TaskServiceInterface $taskService)
    {
    }

    public function getAllTasks()
    {
        $tasks = $this->taskService->recoverTasks();
        return response()->json($tasks);
    }
    public function createOneTask(CreateTaskRequest $request)
    {

        $eletro = $this->taskService->createTask($request->all());

        return response()->json($eletro['data'], $eletro['status_code']);
    }

    public function editTask(EditTaskRequest $request, $id)
    {


        $task = $this->taskService->editTask($request->all(), $id);

        return response()->json($task['data'], Response::HTTP_ACCEPTED);
    }

    public function getOneTask($id)
    {

        $task = $this->taskService->recoverOneTask($id);

        return response()->json($task['data'], $task['status_code']);
    }
    public function deleteTask($id)
    {


        $task = $this->taskService->deleteTask($id);

        return response()->json($task, Response::HTTP_ACCEPTED);
    }
}
