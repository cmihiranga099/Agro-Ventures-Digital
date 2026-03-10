<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'in_progress', 'completed']);

        return [
            'user_id' => User::factory(),
            'title' => ucfirst($this->faker->words(3, true)),
            'description' => $this->faker->optional(0.7)->sentence(10),
            'status' => $status,
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'due_date' => $this->faker->optional(0.8)->dateTimeBetween('now', '+30 days'),
            'deleted_at' => null,
        ];
    }
}
