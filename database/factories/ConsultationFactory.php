<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Consultation;
use Faker\Generator as Faker;

$factory->define(Consultation::class, function (Faker $faker) {
    return [
        'motif' => $faker->text(),
        'debut_symptome' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'examen' => $faker->text(),
        'compte_rendu' => $faker->text(),
        'orientation' => $faker->text(),
        'certificat' => $faker->text(),
        'date_consultation' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
