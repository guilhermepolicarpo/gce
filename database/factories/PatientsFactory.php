<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'birth' => $this->faker->date(),
            'phone' => $this->faker->number(11),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
