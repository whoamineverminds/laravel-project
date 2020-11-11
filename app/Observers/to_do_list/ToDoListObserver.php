<?php

namespace App\Observers\to_do_list;

use App\Models\to_do_list\ToDoList;

class ToDoListObserver
{
    /**
     * Handle the ToDoList "creating" event.
     *
     * @param  \App\Models\to_do_list\ToDoList  $toDoList
     * @return void
     */
    public function creating(ToDoList $toDoList)
    {
        $toDoList->user_id = \Auth::user()->id;
    }
}
