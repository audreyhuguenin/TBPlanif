<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    public function testSubtask()
    {
        $task=factory(\App\Task::class)->create();

        $this->assertInstanceOf('\App\Subtask', $task->subtask);
    }


    public function testAssignations()
    {
        $assignation=factory(\App\Assignation::class)->create();
        $task=factory(\App\Task::class)->create();
        $assignation->task_id = $task->id;
        $assignation->save();

        $assignations=$task->assignations;

        $this->assertInstanceOf('\App\Assignation', $assignations->first());
    }
}
