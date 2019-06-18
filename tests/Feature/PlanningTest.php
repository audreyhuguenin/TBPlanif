<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanningTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllPlannings()
    {
        $plannings = factory(\App\Planning::class, 10)->create();
        $response = $this->get('/plannings');

        $response->assertStatus(200);
        $response->assertJson($plannings->toArray());
    } 
    public function testGetPlanningById()
    {
        $plannings = factory(\App\Planning::class)->create();

        $response = $this->get('/plannings/'. $plannings->id);

        $response->assertStatus(200);
        
    }
    public function testUserCanStorePlanning()
    {
        $user = factory(\App\User::class)->create();

        $data=[
            'sent' => 0,
            'user_id' => $user->id,
        ];

        $response = $this->post('/plannings', $data);

        $this->assertDatabaseHas('plannings', $data);
        $response->assertStatus(201);
         $response->assertJson($data);
        
    }
    public function testUpdatePlanning()
    {
        $planning = factory(\App\Planning::class)->create();

        $data=['sent' => 1];
        $response = $this->patch('/plannings/' . $planning->id, $data);

        $this->assertDatabaseHas('plannings', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
      
    }

}
