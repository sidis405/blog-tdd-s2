<?php

use Faker\Generator as Faker;

$factory->define(Acme\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
