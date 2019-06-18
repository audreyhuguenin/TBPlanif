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
}
