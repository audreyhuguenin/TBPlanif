<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubtaskTest extends TestCase
{
    use RefreshDatabase;
    public function testGetAllSubtasks()
    {
        $subtasks = factory(\App\Subtask::class, 10)->create();
        $response = $this->get('/subtasks');

        $response->assertStatus(200);
        $response->assertJson($subtasks->toArray());
    } 
    public function testGetSubtaskById()
    {
        $subtask = factory(\App\Subtask::class)->create();


        $response = $this->get('/subtasks/'. $subtask->id);

        $response->assertStatus(200);
        
    }
}
