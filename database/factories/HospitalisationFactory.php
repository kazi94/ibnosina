<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Hospitalisation;
use Faker\Generator as Faker;

$factory->define(Hospitalisation::class, function (Faker $faker) {
    return [
        'hopital' => "CHU Tlemcen",
        'service' => $faker->word(),
        'num_biais' => $faker->randomDigitNotNull(),
        'chambre' => $faker->randomDigitNotNull(),
        'lit' => $faker->randomDigitNotNull(),
        'motifs' => $faker->text(),
        'date_admission' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'date_sortie' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'motif_sortie' => $faker->text(),
        'service_transfert ' => $faker->word(),
    ];
});
