<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanningTest extends TestCase
{

    use RefreshDatabase;

    public function testUser()
    {
        $planning=factory(\App\Planning::class)->create();

        $this->assertInstanceOf('\App\User', $planning->user);
    }
    public function testGlobalPlanning()
    {
        $planning1=factory(\App\Planning::class)->create();
        $planningParent=factory(\App\Planning::class)->create();
        $planning1->parent_id = $planningParent->id;
        $planning1->save();


        $this->assertInstanceOf('\App\Planning', $planning1->globalPlanning);
    }

    public function testChildren()
    {
        $planning1=factory(\App\Planning::class)->create();
        $planningChild=factory(\App\Planning::class)->create();
        $planningChild->parent_id = $planning1->id;
        $planningChild->save();

        $child=$planning1->children;

        $this->assertInstanceOf('\App\Planning', $child->first());
    }

    public function testProjects()
    {
        $plannings= factory(\App\Planning::class, 10)->create()->each(function($a) {
            $a->projects()->save(factory(\App\Project::class)->make());
          });
          
        $planning= $plannings->first();
        $projects=$planning->projects;

        $this->assertInstanceOf('\App\Project', $projects->first());
    }

    
}
