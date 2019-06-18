<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testPlannings(){
        $user=factory(\App\User::class)->create();

        $planning = factory(\App\Planning::class)->create();

        $this->assertInstanceOf('\App\Planning', $user->plannings);
    }
    
}
