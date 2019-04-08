<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Acme\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->sentence,
        // 'slug' => Str::slug($title),
        'user_id' => factory(Acme\Models\User::class),
        'category_id' => factory(Acme\Models\Category::class),
    ];
});
