<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Prescription;
use Faker\Generator as Faker;

$factory->define(Prescription::class, function (Faker $faker) {
    return [
        'etats' => "prescription",
        'date_prescription' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
