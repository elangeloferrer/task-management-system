<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'mysql');
    }

    public function testCreateTask()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Success
        $taskData = [
            'title' => $this->faker->bothify('???#'),
            'description' => $this->faker->sentence(),
            'status' => 'pending',
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'user_id' => $user->id,
            'order' => 1,
        ];

        $response = $this->post('/api/tasks', $taskData);
        $response->assertCreated();

        // // Error
        $taskData = [
            'title' => $this->faker->bothify('???#'),
            'description' => $this->faker->sentence(),
            'status' => 'pending',
            'priority' => $this->faker->randomElement(['zxc', 'qw', 'asd']),
            'user_id' => 2,
            'order' => 1,
        ];

        $response = $this->post('/api/tasks', $taskData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'description', 'status', 'priority', 'user_id', 'order']);
    }

    public function testGetTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user, 'sanctum');

        // Success
        $response = $this->get("/api/tasks/{$task->id}");
        $response->assertOk();

        // Error
        $response = $this->get("/api/tasks/0");
        $response->assertStatus(404);
    }

    public function testUpdateTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user, 'sanctum');

        // Success
        $taskData = [
            'title' => "UPDATED TITLE " . $user->id,
            'description' => "UPDATED DESCRIPTION " . $user->id,
            'status' => 'pending',
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'user_id' => $user->id,
            'order' => 1,
        ];
        $response = $this->put("/api/tasks/{$task->id}", $taskData);
        $response->assertOk();

        // Error
        $response = $this->post('/api/tasks', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'description', 'status', 'priority', 'user_id', 'order']);
    }

    public function testDeleteTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->delete("/api/tasks/{$task->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
