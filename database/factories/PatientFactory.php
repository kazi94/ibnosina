<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Patient;
use Faker\Generator as Faker;
use App\Models\Automedication;
use App\Models\Bilan;
use App\Models\Consultation;
use App\Models\Hospitalisation;
use App\Models\Ligneprescription;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'nom' => $faker->name,
        'prenom' => $faker->name,
        'date_naissance' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'num_securite_sociale' => $faker->randomNumber(2, true),
        'code_national' => $faker->randomNumber(8, true),
        'groupe_sanguin' => "ab+",
        'num_dossier' => $faker->randomNumber(2, true),
        'taille' => $faker->randomNumber(3, true),
        'adresse' => $faker->word(),
        'ville' => $faker->word(),
        'commune' => $faker->word(),
        'situation_familliale' => $faker->word(),
        'nbre_enfants' => $faker->randomNumber(1, true),
        'poids' => $faker->randomNumber(2, true),
        'travaille1' => $faker->word(),
        'travaille' => $faker->word(),
        'sexe' => $faker->word(),
        'etat' => $faker->word(),
        'tabagiste' => "1",
        'tabagiste_depuis' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'tabagiste_arreter_depuis' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'cigarettes' => $faker->randomNumber(1, true),
        'alcoolique' => "1",
        'alcoolique_depuis' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'drogue' => "1",
        'drogue_depuis' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'num_tel_1' => $faker->randomNumber(8, true),
        'num_tel_2' => $faker->randomNumber(8, true),
        'details' => $faker->word(),
        'p_tierce' => $faker->word(),
        'cosanguinite' => "cycle 1",
        'debut_regles' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'duree_cycle' => "3",
    ];
});
// $factory->afterCreating(Patient::class, function ($patient, $faker) {
//     $patient->consultations()->createMany(
//         factory(Consultation::class, 3)->make()->toArray()
//     );
// });
// $factory->afterCreating(Patient::class, function ($patient, $faker) {

//     $patient->hospitalisation()->createMany(
//         factory(Hospitalisation::class, 3)->make()->toArray()
//     );
// });
