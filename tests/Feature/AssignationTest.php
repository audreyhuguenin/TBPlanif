<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Assignation;

class AssignationTest extends TestCase
{

    use RefreshDatabase;

       public function testGetAllAssignations()
    {
        $assignations = factory(\App\Assignation::class, 2)->create();
        $response = $this->get('/assignations');

        $response->assertStatus(200);
    } 
    
    public function testGetTaskByID()
    {
        $assignation = factory(\App\Assignation::class)->create();


        $response = $this->get('/assignations/'. $assignation->id);

        $response->assertStatus(200);
        
    }
   
    public function testUserCanStoreAssignation()
    {
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
        $assignation = factory(\App\Assignation::class)->create();

        $response = $this->delete('/assignations/' . $assignation->id);

        $this->assertDatabaseMissing('assignations', ['id'=>$assignation->id,'date'=>$assignation->date]);
        $response->assertStatus(204);
        
    } 

     public function testUpdateAssignation()
    {
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
        $assignation = factory(\App\Assignation::class, 10)->create();
        $data=['weekStart'=>'2019-06-01 08:30:00',
                'weekEnd'=>'2019-06-05 08:30:00'];
        $response = $this->post('/assignations/weekplan', $data);

        //$this->assertInstanceOf('\App\Assignation', $assignation);
  
        $response->assertStatus(200);
     
    } 
    public function testWeekPlanByUser()
    {
        $user = factory(\App\User::class)->create();
        $assignation = factory(\App\Assignation::class, 10)->create();
        $data=['weekStart'=>'2019-06-01 08:30:00',
                'weekEnd'=>'2019-06-05 08:30:00'];
        $response = $this->post('/assignations/weekplanbyuser/'.$user->id, $data);
    
        //$this->assertInstanceOf('\App\Assignation', $assignation);
  
        $response->assertStatus(200);
      
    } 

    
}
