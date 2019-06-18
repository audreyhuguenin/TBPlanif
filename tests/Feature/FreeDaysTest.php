<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FreeDaysTest extends TestCase
{
    use RefreshDatabase;

       public function testGetAllFreeDays()
    {
        $freedays = factory(\App\FreeDay::class, 5)->create();
        $response = $this->get('/freedays');

        $response->assertStatus(200);
    } 
    
    public function testGetbyUser()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->get('/freedays/getbyuser/'. $user->id);

        $response->assertStatus(200);        
    }

    public function testGetFreeDayByID()
    {
        $freeday = factory(\App\FreeDay::class)->create();


        $response = $this->get('/freedays/'. $freeday->id);

        $response->assertStatus(200);        
    }
   
    public function testUserCanStoreFreeDay()
    {
        $user = factory(\App\User::class)->create();

        $data=[
            'startDate' => '2028-04-25 08:30:00',
            'endDate' => '2028-04-26 08:30:00',
            'user_id' => $user->id,
            ];

        $response = $this->post('/freedays', $data);

        $this->assertDatabaseHas('free_days', $data);
        $response->assertStatus(201);
         $response->assertJson($data);

        
    } 

     public function testUserCanDestroyFreeday()
    {
        $day = factory(\App\FreeDay::class)->create();

        $response = $this->delete('/freedays/' . $day->id);

        $this->assertDatabaseMissing('free_days', ['id'=>$day->id,'startDate'=>$day->startDate]);
        $response->assertStatus(204);
        
    } 

     public function testUpdateFreeDay()
    {
        $day = factory(\App\FreeDay::class)->create();

        $data=[
            'startDate' => '2028-04-23 08:30:00',
            'endDate'=>'2028-04-28 08:30:00'
        ];
        $response = $this->patch('/freedays/' . $day->id, $data);

        $this->assertDatabaseHas('free_days', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
      
    } 

}
