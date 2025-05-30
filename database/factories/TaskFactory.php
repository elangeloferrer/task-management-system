<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'completed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'order' => rand(1, 10),
            'user_id' => Role::where('code', 'user')->first()->id,
        ];
    }
}
