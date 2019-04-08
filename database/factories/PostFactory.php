<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->sentence,
        // 'slug' => Str::slug($title),
        'user_id' => factory(App\User::class),
        'category_id' => factory(App\Category::class),
    ];
});
