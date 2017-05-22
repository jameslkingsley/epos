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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Basket\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
        'label' => $faker->sentence
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city
    ];
});

$factory->define(App\Basket\Models\Price::class, function (Faker\Generator $faker) {
    return [
        'trade' => $faker->numberBetween(20, 500),
        'markup' => $faker->randomFloat(2, 0, 1),
        'vat' => $faker->randomElement([0, 0.05, 0.1, 0.2, 0.25])
    ];
});
