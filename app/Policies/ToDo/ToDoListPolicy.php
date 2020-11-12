<?php

namespace App\Policies\ToDo;

use App\Models\ToDo\ToDoList;
use App\Models\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToDoListPolicy
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
    public function actions(User $user, ToDoList $list)
    {
        return $user === $list->getUser();
    }
}
