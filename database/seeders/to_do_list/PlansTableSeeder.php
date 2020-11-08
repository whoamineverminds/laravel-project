<?php

namespace Database\Seeders\to_do_list;

use App\Models\to_do_list\ToDoPlan;
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
