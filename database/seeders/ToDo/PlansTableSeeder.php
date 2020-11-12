<?php

namespace Database\Seeders\ToDo;

use App\Models\ToDo\ToDoPlan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ToDoPlan::factory(100)->create();
    }
}
