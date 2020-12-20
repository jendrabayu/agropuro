<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Forum;
use App\ForumCategory;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Forum::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'forum_category_id' => function () {
            return ForumCategory::inRandomOrder()->first()->id;
        },
        'title' => $faker->text,
        'slug' => Str::slug($faker->unique()->text),
        'body' => $faker->paragraph(5),
        'is_solved' => $faker->boolean(50)
    ];
});
