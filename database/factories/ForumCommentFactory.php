<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Forum;
use App\ForumComment;
use App\User;
use Faker\Generator as Faker;

$factory->define(ForumComment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'forum_id' => function () {
            return Forum::inRandomOrder()->first()->id;
        },
        'forum_comment_id' => null,
        'body' => $faker->text,
        'is_answer' => $faker->boolean(50)
    ];
});
