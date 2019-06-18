<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
{
    use RefreshDatabase;
    

    public function testGetAllUsers()
    {
        $users = factory(\App\User::class, 10)->create();
        $response = $this->get('/users');
        $response->assertStatus(200);
        $response->assertJson($users->toArray());
    } 

     public function testGetUserByID()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->get('/users/'.$user->id);
        $response->assertStatus(200);
    }

    public function testUpdateUser()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->patch('/users/' . $user->id, [
            'contractRate' => 120,
        ]);

        $this->assertDatabaseHas('users', ['contractRate' => 120]);
        $response->assertStatus(200);
        $response->assertJson(['contractRate'=>120]);
      
    }
}
