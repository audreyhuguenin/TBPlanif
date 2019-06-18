<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Subtask;
use Faker\Generator as Faker;

$factory->define(Subtask::class, function (Faker $faker) {
    return [
        'name' => $faker->bs(),
        'project_id'=> function () {
            $project = factory(App\Project::class)->create();
            return $project->number;
        }
    ];
});
