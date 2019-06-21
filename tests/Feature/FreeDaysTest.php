<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FreeDaysTest extends TestCase
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

       public function testGetAllFreeDays()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $freedays = factory(\App\FreeDay::class, 5)->create();
        $response = $this->get('/freedays');

        $response->assertStatus(200);
    } 
    
    public function testGetbyUser()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $user = factory(\App\User::class)->create();

        $response = $this->get('/freedays/getbyuser/'. $user->id);

        $response->assertStatus(200);        
    }

    public function testGetFreeDayByID()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $freeday = factory(\App\FreeDay::class)->create();


        $response = $this->get('/freedays/'. $freeday->id);

        $response->assertStatus(200);        
    }
   
    public function testUserCanStoreFreeDay()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
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
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $day = factory(\App\FreeDay::class)->create();

        $response = $this->delete('/freedays/' . $day->id);

        $this->assertDatabaseMissing('free_days', ['id'=>$day->id,'startDate'=>$day->startDate]);
        $response->assertStatus(204);
        
    } 

     public function testUpdateFreeDay()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
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
