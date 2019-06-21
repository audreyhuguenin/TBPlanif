<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class UserTest extends TestCase
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
    

    public function testGetAllUsers()
    {        
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $response = $this->get('/users');
        $response->assertStatus(200);
    } 

     public function testGetUserByID()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $response = $this->get('/users/'.$user->id);
        $response->assertStatus(200);
    }

    public function testUpdateUser()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);

        $response = $this->patch('/users/' . $user->id, [
            'contractRate' => 100,
        ]);

        //dd($user);
        $this->assertDatabaseHas('users', ['contractRate' => 100]);
        $response->assertStatus(200);
      
    }

}
