<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Assignation;
use Faker\Generator as Faker;

$factory->define(Assignation::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeThisMonth($max = 'now') ,
        'duration' => $faker->numberBetween($min=1,$max=8),
        'type' => '{"type": [
            {"value": "PC"},
            {"value": "RDV"},
            {"value": "L"}
         ]}',
        'suiviDA' =>rand(0, 1),
        'unmovable' =>rand(0, 1),
        'task_id' => function () {
            $task = factory(App\Task::class)->create();
            return $task->id;    
        },
        'user_id' => function () {
            $user = factory(App\User::class)->create();
            return $user->id;    
        }
    ];
});
