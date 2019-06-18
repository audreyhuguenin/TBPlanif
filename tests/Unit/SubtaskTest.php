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
}
