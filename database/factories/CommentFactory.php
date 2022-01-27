<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'messages' => $this->faker->realText(50),
    ];
});
