<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LignePrescription;
use Faker\Generator as Faker;

$factory->define(LignePrescription::class, function (Faker $faker) {
    return [
        'nbr_jours' => "10",
        'dose' => "3",
        'type_j' => "jours",
        'dose_matin' => "1",
        'dose_mat' => "1",
        'repas_matin' => "1",
        'dose_midi' => "1",
        'repas_midi' => "1",
        'dose_mid' => "1",
        'dose_soir' => "1",
        'repas_soir' => "1",
        'dose_soi' => "1",
        'dose_avant_coucher' => "1",
        'dose_ac' => "1",
        'unite' => "comp",
        'voie' => "orale",
        'med_sp_id' => "17883",
    ];
});
