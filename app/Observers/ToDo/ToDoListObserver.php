<?php

namespace App\Observers\ToDo;

use App\Models\ToDo\ToDoList;

class ToDoListObserver
{
    /**
     * Handle the ToDoList "creating" event.
     *
     * @param  \App\Models\ToDo\ToDoList  $toDoList
     * @return void
     */
    public function creating(ToDoList $toDoList)
    {
        $toDoList->user_id = \Auth::user()->id;
    }
}
