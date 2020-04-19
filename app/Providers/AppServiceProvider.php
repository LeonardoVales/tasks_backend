<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observers\TaskObserver;
use App\Task;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Task::observe(TaskObserver::class);
    }
}
