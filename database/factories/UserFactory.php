<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Hotels::class, function (Faker $faker) {
    return [
        'street_address' => $faker->streetAddress,
        'name' => $faker->company,
        'city' => $faker->city,
        'state' => $faker->country,
        'rating' => random_int(1, 5)
    ];
});

$factory->define(App\Rooms::class, function (Faker $faker) {
    $availabilities = ['AVAILABLE', 'ON REQUEST', 'SOLD OUT'];
    $roomTypes = ['1 Bedroom ', '2 Bedroom ', 'Studio Suite ', 'Junior Suite ', 'Suite '];

    return [
        'hotels_id' => '',
        'name' => $roomTypes[random_int(0, sizeof($roomTypes) - 1)] . $faker->company,
        'price' => $faker->randomFloat(2, 300, 800),
        'availability' => $availabilities[random_int(0,2)],

    ];
});
