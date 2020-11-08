<?php

namespace Database\Seeders\to_do_list;

use App\Models\to_do_list\ToDoList;
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
