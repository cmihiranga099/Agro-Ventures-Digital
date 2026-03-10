<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_sees_only_their_tasks(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        Task::factory()->for($user)->count(2)->create();
        Task::factory()->for($other)->count(2)->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/tasks');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'title' => 'API Task',
            'status' => 'pending',
            'priority' => 'medium',
            'description' => 'Via API',
            'due_date' => now()->addDay()->toDateString(),
        ];

        $this->postJson('/api/tasks', $payload)
            ->assertCreated()
            ->assertJsonPath('data.title', 'API Task');

        $this->assertDatabaseHas('tasks', [
            'title' => 'API Task',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_soft_delete_and_restore(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $task = Task::factory()->for($user)->create();

        $this->deleteJson("/api/tasks/{$task->id}")->assertOk();
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);

        $this->postJson("/api/tasks/{$task->id}/restore")->assertOk();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'deleted_at' => null]);
    }
}
