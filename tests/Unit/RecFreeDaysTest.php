<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecFreeDaysTest extends TestCase
{
    public function testUsers()
    {
        $days= factory(\App\RecurrentFreeDay::class, 10)->create()->each(function($a) {
            $a->users()->save(factory(\App\User::class)->make());
          });
          
        $day= $days->first();
        $users=$day->users;

        $this->assertInstanceOf('\App\User', $users->first());
    }
}
