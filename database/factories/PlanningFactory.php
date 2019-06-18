<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Planning;
use Faker\Generator as Faker;

$factory->define(Planning::class, function (Faker $faker) {
    return [
        'sent'=>0,
        'user_id'=>function () {
            $user = factory(App\User::class)->create();
            return $user->id;    
        },

    ];
});
