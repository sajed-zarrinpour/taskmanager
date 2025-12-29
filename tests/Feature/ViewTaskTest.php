<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTaskTest extends TestCase
{
    /**
     * authenticated user should be able to view his tasks
     */
    public function test_authenticated_user_views_one_of_his_tasks(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->forUser($user)->create();
        
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/api/v1/tasks/'.$task->id);

        $response->assertStatus(200);
    }

    /**
     * authenticated user should not be able to view another users tasks
     */
    public function test_authenticated_user_should_not_view_another_users_tasks(): void
    {
        $user = User::factory()->create();
        
        $another_user = User::factory()->create();
        $task = Task::factory()->forUser($another_user)->create();
        
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/api/v1/tasks/'.$task->id);
        // make sure the server rejects the request with unauthorized status
        $response->assertStatus(403);
    }
}
