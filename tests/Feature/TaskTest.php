<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class TaskTest extends TestCase
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
    public function testGetAllTasks()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $tasks = factory(\App\Task::class, 10)->create();
        $response = $this->get('/tasks');

        $response->assertStatus(200);
        $response->assertJson($tasks->toArray());
    } 
    public function testGetTaskById()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $task = factory(\App\Task::class)->create();


        $response = $this->get('/tasks/'. $task->id);

        $response->assertStatus(200);
        
    }
    public function testUserCanStoreTask()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $subtask = factory(\App\Subtask::class)->create();

        $data=[
            'name' => 'test',
            'comment' => 'test comment',
            'subtask_id' => $subtask->id,
        ];

        $response = $this->post('/tasks', $data);

        $this->assertDatabaseHas('tasks', $data);
        $response->assertStatus(201);
         $response->assertJson($data);
        
    }

    public function testUserCanDestroyTask()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $task = factory(\App\Task::class)->create();

        $response = $this->delete('/tasks/' . $task->id);

        $this->assertDatabaseMissing('tasks', ['id'=>$task->id,'name'=>$task->name]);
        $response->assertStatus(204);
        
    }

    public function testUpdateTask()
    {
        $user=\App\User::where(['email'=>'audrey.huguenin'])->first();
        $this->actingAs($user);
        $task = factory(\App\Task::class)->create();

        $data=['name' => 'test new taskname'];
        $response = $this->patch('/tasks/' . $task->id, $data);

        $this->assertDatabaseHas('tasks', $data);
        $response->assertStatus(200);
        $response->assertJson($data);
      
    }
}
