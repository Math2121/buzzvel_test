<?php

namespace Tests\Unit;


use App\Http\Interfaces\TaskRepositoryInterface;

use App\Http\Services\TaskService;

use App\Models\Task;


use Tests\TestCase;
use Illuminate\Http\UploadedFile;
class TaskServiceTest extends TestCase
{

    private $taskRepository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->taskRepository = $this->createMock(TaskRepositoryInterface::class);
    }

    public function test_deve_cadastrar_task()
    {
        $this->taskRepository->method('saveATask')
            ->willReturn($this->task());

        $service = $this->instanciaTask();
        $file = UploadedFile::fake()->create('test_file.txt', 100);
        $task = $service->createTask([
            'title' => 'Teste',
            'description' => 'teste',
            'file' => $file,
            'status' => 'completed',
            'dates' => "2023-06-09"
        ]);

        $this->assertIsArray($task);


    }

    public function test_deve_editar_task()
    {
        $taskData = [
            'title' => 'Teste2'
        ];
        $this->taskRepository->method('getTask')
        ->willReturn(true);
        $this->taskRepository->method('editOneTask')
            ->with($taskData, 1)
            ->willReturn([
                'title' => 'Teste2',
                'description' => 'teste',
                'file' => 'test.csv',
                'status' => 'completed',
                'dates' => "2023-06-09"
            ]);
        $service = $this->instanciaTask();

        $task = $service->editTask([
            'title' => 'Teste2'
        ], 1);


        $this->assertArrayHasKey('title', $task['data']);

    }

    public function test_nao_deve_editar_task()
    {

        $this->taskRepository->method('getTask')
        ->willReturn(false);

        $service = $this->instanciaTask();

        $task = $service->editTask([
            'title' => 'Teste2'
        ], 1);


        $this->assertEquals('Not found Task', $task['data']);

    }

    public function test_deve_listar_tasks()
    {

        $this->taskRepository->method('tasksList')
        ->willReturn($this->tasks());

        $service = $this->instanciaTask();

        $task = $service->recoverTasks();

        $this->assertInstanceOf(Task::class, $task[0]);

    }

    public function test_deve_listar_task()
    {

        $this->taskRepository->method('getTask')
        ->with(1)
        ->willReturn($this->tasks()[0]);

        $service = $this->instanciaTask();

        $task = $service->recoverOneTask(1);

        $this->assertInstanceOf(Task::class, $task['data']);

    }

    public function test_nao_deve_apagar_task()
    {

        $this->taskRepository->method('getTask')
        ->with(1)
        ->willReturn(false);

        $service = $this->instanciaTask();

        $task = $service->deleteTask(1);

        $this->assertEquals("Not found Task", $task['data']);

    }
    public function test_deve_apagar_task()
    {

        $this->taskRepository->method('getTask')
        ->with(1)
        ->willReturn(true);
        $this->taskRepository->method('deleteOneTask')
        ->with(1);
        $service = $this->instanciaTask();

        $task = $service->deleteTask(1);

        $this->assertTrue($task);

    }


    public function task()
    {
        return [
            Task::make([
                'title' => 'Teste',
                'description' => 'teste',
                'file' => 'test.csv',
                'status' => 'completed',
                'dates' => "2023-06-09"
            ])
        ];
    }

    public function tasks()
    {
        return [
            Task::make([
                'title' => 'Teste',
                'description' => 'teste',
                'file' => 'test.csv',
                'status' => 'completed',
                'dates' => "2023-06-09"
            ]),
            Task::make([
                'title' => 'Teste',
                'description' => 'teste',
                'file' => 'test.csv',
                'status' => 'completed',
                'dates' => "2023-06-09"
            ])
        ];
    }



    public function instanciaTask()
    {
        return new TaskService(
            $this->taskRepository
        );
    }
}
