<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanStoreTask()
    {
        $subtask = factory(\App\Subtask::class)->create();

        $response = $this->post('/tasks', [
            'name' => 'test',
            'comment' => 'test comment',
            'subtask_id' => $subtask->id,
        ]);

        $this->assertDatabaseHas('tasks', [
            'name' => 'test',
            'comment' => 'test comment',
            'subtask_id' => $subtask->id,
        ]);
        $response->assertStatus(302);
    }
}
