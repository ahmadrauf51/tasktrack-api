<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    public $user;
    public $task;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_index()
    {
        $response = $this->actingAs($this->user, 'sanctum')->get('api/task');
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $response = $this->actingAs($this->user, 'sanctum')->post('api/task', [
            'user_id' => $this->user->id,
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'todo', // Assuming 'todo' is a valid status
            'parent_task_id' => null, // Assuming no parent task
        ]);

        $response->assertStatus(201);
    }

    public function test_show()
    {
        $response = $this->actingAs($this->user, 'sanctum')->get('api/task/' . $this->task->id);
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $response = $this->actingAs($this->user, 'sanctum')->put('api/task/' . $this->task->id, [
            'user_id' => $this->user->id,
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'todo', // Assuming 'todo' is a valid status
            'parent_task_id' => null, // Assuming no parent task
        ]);
        $response->assertStatus(202);
    }

    public function test_destroy()
    {
        $response = $this->actingAs($this->user, 'sanctum')->delete('api/task/' . $this->task->id);
        $response->assertStatus(204);
    }
}
