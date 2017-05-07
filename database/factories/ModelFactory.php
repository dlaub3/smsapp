<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Smsapp\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->phoneNumber,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Smsapp\Group::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'slug' => function (array $group) {
            return str_slug($group['name']);
        },
        'user_id' => $faker->randomElement(Smsapp\User::pluck('id')->toArray()),
    ];
});

$factory->define(Smsapp\GroupsUser::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'phone_number' => $faker->phoneNumber,
        'group_id' => $faker->randomElement(Smsapp\Group::pluck('id')->toArray()),
    ];
});
