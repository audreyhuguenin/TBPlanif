<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->bs(),
        'comment' => $faker->realText(),
        'subtask_id' => function () {
            $subtask = factory(App\Subtask::class)->create();
            return $subtask->project_id;
        }
    ];
});
