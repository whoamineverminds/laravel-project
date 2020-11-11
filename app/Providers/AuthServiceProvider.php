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
        'App\Models\to_do_list\ToDoList' => 'App\Policies\to_do_list\ToDoListPolicy',
        'App\Models\to_do_list\ToDoPlan' => 'App\Policies\to_do_list\ToDoPlanPolicy',
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
