<?php

use Faker\Generator as Faker;

$factory->define(App\Supply::class, function (Faker $faker) {
    return [
        //
        'transfer_code' => Str::random(10),
        'supplier_id' => function () {
            return factory(App\Supplier::class)->create()->id;
        },
        'item' => $faker->randomElement(['milk','flour','salt','yeast','sugar','eggs','butter']),
        'status' => "initiated",
        'quantity_desc' => $faker->paragraph,
        'amount' => rand(100, 9999)."00",
        'supply_type' => "prepaid",
        'paid' => "no",
    ];
});
