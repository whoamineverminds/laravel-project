<?php

namespace Database\Factories;

use App\Models\Plans;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlansFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plans::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'list_id' => rand(1, 10),
            'title' => $this->faker->title,
            'description' => $this->faker->sentence(rand(4, 10)),
            'priority' => rand(1, 5),
            'complete'=> (bool)rand(0, 1)
        ];
    }
}
