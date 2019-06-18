<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\FreeDay;
use Faker\Generator as Faker;

$factory->define(FreeDay::class, function (Faker $faker) {
    return [
        'startDate'=>$faker->dateTime(),
        'endDate'=>$faker->dateTime(),
        'user_id'=>function () {
            $user = factory(App\User::class)->create();
            return $user->id;    
        }
    ];
});
