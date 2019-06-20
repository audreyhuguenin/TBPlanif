<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testPlannings()
    {
        $planning=factory(\App\Planning::class)->create();
        $user=factory(\App\User::class)->create();
        $planning->user_id = $user->id;
        $planning->save();

        $plannings=$user->plannings;

        $this->assertInstanceOf('\App\Planning', $plannings->first());
    }

    public function testAssignations()
    {
        $assignation=factory(\App\Assignation::class)->create();
        $user=factory(\App\User::class)->create();
        $assignation->user_id = $user->id;
        $assignation->save();

        $assignations=$user->assignations;

        $this->assertInstanceOf('\App\Assignation', $assignations->first());
    }

    public function testfreeDays()
    {
        $day=factory(\App\FreeDay::class)->create();
        $user=factory(\App\User::class)->create();
        $day->user_id = $user->id;
        $day->save();

        $days=$user->freeDays;

        $this->assertInstanceOf('\App\FreeDay', $days->first());
    }

    public function testRecFreeDays()
    {
        $users= factory(\App\User::class, 10)->create()->each(function($a) {
            $a->recurrentFreeDays()->save(factory(\App\RecurrentFreeDay::class)->make());
          });
          
        $user= $users->first();
        $days=$user->recurrentFreeDays;

        $this->assertInstanceOf('\App\RecurrentFreeDay', $days->first());
    }
    
    
}
