<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubtaskTest extends TestCase
{
    public function testProject()
    {
        $subtask=factory(\App\Subtask::class)->create();

        $this->assertInstanceOf('\App\Project', $subtask->project);
    }

    public function testTasks()
    {
        $task=factory(\App\Task::class)->create();
        $subtask=factory(\App\Subtask::class)->create();
        $task->subtask_id = $subtask->id;
        $task->save();

        $tasks=$subtask->tasks;
      

        $this->assertInstanceOf('\App\Task', $tasks->first());
    }
}
