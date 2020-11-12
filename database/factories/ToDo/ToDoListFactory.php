<?php

namespace Database\Factories\ToDo;

use App\Models\ToDo\ToDoList;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToDoListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToDoList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return ['title' => $this->faker->title];
    }
}
