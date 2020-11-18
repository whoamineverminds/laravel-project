<?php

namespace Database\Seeders;

use Database\Seeders\Auth\UsersTableSeeder;
use Database\Seeders\ToDo\ListsTableSeeder;
use Database\Seeders\ToDo\PlansTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ListsTableSeeder::class);
        $this->call(PlansTableSeeder::class);
    }
}
