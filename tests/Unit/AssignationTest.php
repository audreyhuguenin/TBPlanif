<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignationTest extends TestCase
{
    public function testUser()
    {
        $assignation=factory(\App\Assignation::class)->create();

        $this->assertInstanceOf('\App\User', $assignation->user);
    }
    public function testTask()
    {
        $assignation=factory(\App\Assignation::class)->create();

        $this->assertInstanceOf('\App\Task', $assignation->task);
    }
}
