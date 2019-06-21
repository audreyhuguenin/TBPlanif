<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubtaskTest extends TestCase
{
    use RefreshDatabase;

    //use WithoutMiddleware;

    public function testSeedRights()
    {
        $response=$this->get('/rights/seed');
        $this->assertDatabaseHas('rights', ['id' => 20]);
    }

    public function testSyncUsers()
    {
        $response=$this->get('/users/sync');
        $this->assertDatabaseHas('users', ['email' => 'audrey.huguenin']);
        $response->assertStatus(200); 
    }

    public function testGetAllSubtasks()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $subtasks = factory(\App\Subtask::class, 10)->create();
        $response = $this->get('/subtasks');

        $response->assertStatus(200);
        $response->assertJson($subtasks->toArray());
    } 
    public function testGetSubtaskById()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $subtask = factory(\App\Subtask::class)->create();


        $response = $this->get('/subtasks/'. $subtask->id);

        $response->assertStatus(200);
        
    }
}
