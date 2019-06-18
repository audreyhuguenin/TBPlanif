<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FreeDaysTest extends TestCase
{
    public function testUser()
    {
        $freeday=factory(\App\FreeDay::class)->create();

        $this->assertInstanceOf('\App\User', $freeday->user);
    }
}
