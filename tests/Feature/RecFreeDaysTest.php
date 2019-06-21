<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecFreeDaysTest extends TestCase
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

       public function testGetAllRecFreeDays()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $freedays = factory(\App\RecurrentFreeDay::class, 5)->create();
        $response = $this->get('/recurrentfreedays');

        $response->assertStatus(200);
    } 
    
    public function testGetbyUser()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $day= factory(\App\RecurrentFreeDay::class, 50)->create()->each(function($a) {
            $a->users()->save(factory(\App\User::class)->make());
          });

        $response = $this->get('/recurrentfreedays/getbyuser/'. 20);
        $response->assertStatus(200);      
    }

    public function testGetRecFreeDayById()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $day = factory(\App\RecurrentFreeDay::class)->create();

        $response = $this->get('/recurrentfreedays/'. $day->id);

        $response->assertStatus(200);        
    }
   
}
