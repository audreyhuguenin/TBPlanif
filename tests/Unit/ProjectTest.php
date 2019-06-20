<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    public function testPlannings()
    {
        $projects= factory(\App\Project::class, 10)->create()->each(function($a) {
            $a->plannings()->save(factory(\App\Planning::class)->make());
          });
          
        $project= $projects->first();
        $plannings=$project->plannings;

        $this->assertInstanceOf('\App\Planning', $plannings->first());
    }

    public function testSubtasks()
    {
        $subtask=factory(\App\Subtask::class)->create();
        $project=factory(\App\Project::class)->create();
        $subtask->project_id = $project->number;
        $subtask->save();

        $subtasks=$project->subtasks;
      

        $this->assertInstanceOf('\App\Subtask', $subtasks->first());
    }
}
