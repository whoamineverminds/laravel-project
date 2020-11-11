<?php

namespace App\Providers;

use App\Models\to_do_list\ToDoList;
use App\Models\to_do_list\ToDoPlan;
use App\Observers\to_do_list\ToDoListObserver;
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
