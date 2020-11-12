<?php

namespace Database\Seeders\ToDo;

use App\Models\ToDo\ToDoList;
use Illuminate\Database\Seeder;

class ListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ToDoList::factory(10)->create();
    }
}
