<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
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
    
    public function testGetAllProjects()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $projects = factory(\App\Project::class, 10)->create();

        $response = $this->get('/projects');

        $response->assertStatus(200);
        $response->assertJson($projects->toArray());
    }
    public function testGetProjectById()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $project = factory(\App\Project::class)->create();


        $response = $this->get('/projects/'. $project->id);

        $response->assertStatus(200);

    }
}
