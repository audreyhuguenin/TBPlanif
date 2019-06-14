<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Subtask;
use Faker\Generator as Faker;

$factory->define(Subtask::class, function (Faker $faker) {
    return [
        'name' => $faker->bs(),
    ];
});
