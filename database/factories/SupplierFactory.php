<?php

use Faker\Generator as Faker;

$factory->define(App\Supplier::class, function (Faker $faker) {
    return [
        //
        'paystack_recepient_code' => Str::random(10),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'telephone' => "080".rand(11111111, 99999999),
        'address' => $faker->address,
    ];
});
