<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    
    public function testGetAllProjects()
    {
        $projects = factory(\App\Project::class, 10)->create();

        $response = $this->get('/projects');

        $response->assertStatus(200);
        $response->assertJson($projects->toArray());
    }
    public function testGetProjectById()
    {
        $project = factory(\App\Project::class)->create();


        $response = $this->get('/projects/'. $project->id);

        $response->assertStatus(200);

    }
}
