<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    /**
     * authenticated users sould be able to create a task
     */
    public function test_authenticated_user_creates_a_task(): void
    {
        $user = User::factory()->create();
 
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                        ->postJson('/api/v1/tasks', [
                                "title"=>"fake test user creates a task",
                                "status"=> "in_progress"
                        ]);
 
        
        // Assert the status code and the structure of the response
        $response->assertStatus(201)
                ->assertJsonStructure(['id', 'title', 'status', 'created_at', 'updated_at']);

        // the task is created successfully if id is not null and is int
        // Get the id from the response
        $id = $response->json('id');

        // Assert that task is created (the id is present and is an integer and is greater than zero)
        $this->assertNotNull($id);
        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);
    }

    /**
     * unauthenticated user should not be able to create a task
     */
    public function test_unauthenticated_user_should_not_be_able_to_creates_a_task():void {
        $response = $this->postJson('/api/v1/tasks', [
                                "title"=>"fake test user creates a task",
                                "status"=> "in_progress"
                        ]);
        // check to see if the proper rejection behaviour observed
        $response->assertStatus(401)
                 ->assertJsonStructure(['message'])
                 ->assertJson([
                    "message" => "Unauthenticated.",
                 ]);
    }
}
