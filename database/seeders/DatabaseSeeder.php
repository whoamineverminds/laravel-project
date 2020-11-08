<?php

namespace Database\Seeders;

use Database\Seeders\Auth\UsersTableSeeder;
use Database\Seeders\to_do_list\ListsTableSeeder;
use Database\Seeders\to_do_list\PlansTableSeeder;
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
