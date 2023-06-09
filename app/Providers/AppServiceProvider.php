<?php

namespace App\Providers;


use App\Http\Interfaces\TaskRepositoryInterface;
use App\Http\Interfaces\TaskServiceInterface;
use App\Http\Repositories\TaskRepository;
use App\Http\Services\TaskService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
