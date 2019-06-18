<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecFreeDaysTest extends TestCase
{
    use RefreshDatabase;

       public function testGetAllRecFreeDays()
    {
        $freedays = factory(\App\RecurrentFreeDay::class, 5)->create();
        $response = $this->get('/recurrentfreedays');

        $response->assertStatus(200);
    } 
    
    public function testGetbyUser()
    {
        $day= factory(\App\RecurrentFreeDay::class, 50)->create()->each(function($a) {
            $a->users()->save(factory(\App\User::class)->make());
          });

        $response = $this->get('/recurrentfreedays/getbyuser/'. 20);
        $response->assertStatus(200);      
    }

    public function testGetRecFreeDayById()
    {
        $day = factory(\App\RecurrentFreeDay::class)->create();

        $response = $this->get('/recurrentfreedays/'. $day->id);

        $response->assertStatus(200);        
    }
   
}
