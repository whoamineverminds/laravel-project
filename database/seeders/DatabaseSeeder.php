<?php

namespace Database\Seeders;

use App\Models\Lists;
use Illuminate\Database\Seeder;
use App\Models\Plans;

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
        Lists::factory(10)->create();
        Plans::factory(100)->create();
    }
}
