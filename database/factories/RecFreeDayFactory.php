<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\RecurrentFreeDay;
use Faker\Generator as Faker;

$factory->define(RecurrentFreeDay::class, function (Faker $faker) {
    return [
        'jour'=>$faker->word()   
    ];
});
