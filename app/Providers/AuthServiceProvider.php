<?php

namespace App\Providers;

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

        Gate::define('list-owner', function ($user, $list) {
            return $user->id === $list->user_id;
        });
    }
}
