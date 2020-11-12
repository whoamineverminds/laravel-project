<?php

namespace App\Providers;

use App\Models\ToDo\ToDoList;
use App\Observers\ToDo\ToDoListObserver;
use Illuminate\Support\ServiceProvider;

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
        ToDoList::observe(ToDoListObserver::class);
    }
}
