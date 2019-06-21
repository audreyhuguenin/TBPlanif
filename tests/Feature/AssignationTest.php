<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Assignation;

class AssignationTest extends TestCase
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

       public function testGetAllAssignations()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $assignations = factory(\App\Assignation::class, 2)->create();
        $response = $this->get('/assignations');

        $response->assertStatus(200);
    } 
    
    public function testGetTaskByID()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $assignation = factory(\App\Assignation::class)->create();


        $response = $this->get('/assignations/'. $assignation->id);

        $response->assertStatus(200);
        
    }
   
    public function testUserCanStoreAssignation()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $task = factory(\App\Task::class)->create();
        $user = factory(\App\User::class)->create();

        $data=[
            'duration' => rand(1,8),
            'date' => '2028-04-25 08:30:00',
            'type' => '{"type": [
                {"value": "B"},
                {"value": "BO"}
             ]}',
            'suiviDA' => rand(0,1),
            'unmovable' => rand(0, 1),
            'user_id' => $user->id,
            'task_id' => $task->id,
            ];

        $response = $this->post('/assignations', $data);

        $this->assertDatabaseHas('assignations', [
            'date' => '2028-04-25 08:30:00',
            'task_id' => $task->id,
            'user_id' => $user->id
        ]);
        $response->assertStatus(201);
         $response->assertJson($data);

        
    } 

     public function testUserCanDestroyAssignation()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $assignation = factory(\App\Assignation::class)->create();

        $response = $this->delete('/assignations/' . $assignation->id);

        $this->assertDatabaseMissing('assignations', ['id'=>$assignation->id,'date'=>$assignation->date]);
        $response->assertStatus(204);
        
    } 

     public function testUpdateAssignation()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $assignation = factory(\App\Assignation::class)->create();

        $data=[
            'duration' => 6,
            'date'=>'2028-04-27 08:30:00'
        ];
        $response = $this->patch('/assignations/' . $assignation->id, $data);

        $this->assertDatabaseHas('assignations', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
      
    } 

    public function testWeekPlan()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $assignation = factory(\App\Assignation::class, 10)->create();
        $data=['weekStart'=>'2019-06-01 08:30:00',
                'weekEnd'=>'2019-06-05 08:30:00'];
        $response = $this->post('/assignations/weekplan', $data);

        //$this->assertInstanceOf('\App\Assignation', $assignation);
  
        $response->assertStatus(200);
     
    } 
    public function testWeekPlanByUser()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $user = factory(\App\User::class)->create();
        $assignation = factory(\App\Assignation::class, 10)->create();
        $data=['weekStart'=>'2019-06-01 08:30:00',
                'weekEnd'=>'2019-06-05 08:30:00'];
        $response = $this->post('/assignations/weekplanbyuser/'.$user->id, $data);
    
        //$this->assertInstanceOf('\App\Assignation', $assignation);
  
        $response->assertStatus(200);
      
    } 

    
}
