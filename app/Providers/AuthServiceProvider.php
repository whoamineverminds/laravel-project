<?php

namespace App\Providers;

use App\Models\Auth\User;
use App\Models\ToDo\ToDoList;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\ToDo\ToDoList' => 'App\Policies\ToDo\ToDoListPolicy',
        'App\Models\ToDo\ToDoPlan' => 'App\Policies\ToDo\ToDoPlanPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('list-owner', function (User $user, ToDoList $list) {
            return $user->id === $list->getUser()->first()->id;
        });
    }
}
