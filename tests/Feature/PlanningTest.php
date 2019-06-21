<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanningTest extends TestCase
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

    public function testGetAllPlannings()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $plannings = factory(\App\Planning::class, 10)->create();
        $response = $this->get('/plannings');

        $response->assertStatus(200);
        $response->assertJson($plannings->toArray());
    } 
    public function testGetPlanningById()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $plannings = factory(\App\Planning::class)->create();

        $response = $this->get('/plannings/'. $plannings->id);

        $response->assertStatus(200);
        
    }
    public function testUserCanStorePlanning()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
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
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $planning = factory(\App\Planning::class)->create();

        $data=['sent' => 1];
        $response = $this->patch('/plannings/' . $planning->id, $data);

        $this->assertDatabaseHas('plannings', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
      
    }

}
