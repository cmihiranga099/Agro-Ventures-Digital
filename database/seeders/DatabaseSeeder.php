<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        Task::factory()
            ->count(25)
            ->for($user)
            ->sequence(
                ['status' => 'pending'],
                ['status' => 'in_progress'],
                ['status' => 'completed']
            )
            ->create();
    }
}
