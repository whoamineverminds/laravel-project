<?php

namespace App\Policies\ToDo;

use App\Models\Auth\User;
use App\Models\ToDo\ToDoPlan;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToDoPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Auth\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can do any actions with models.
     *
     * @param  \App\Models\Auth\User  $user
     * @return mixed
     */
    public function actions(User $user, ToDoPlan $plan)
    {
        return $user->id === $plan->getList()->first()->user_id;
    }
}
