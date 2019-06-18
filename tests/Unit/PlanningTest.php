<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanningTest extends TestCase
{
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
        $planning1->parent_id = $planningParent->id;
        $planning1->save();


        $this->assertInstanceOf('\App\Planning', $planning1->globalPlanning);
    }

    
}
