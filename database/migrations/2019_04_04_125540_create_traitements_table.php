<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraitementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traitements', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_debut_traitement');
            $table->integer('nombre_cure_prevu');

            $table->string('localisation', 50);
            $table->string('stade', 50)->nullable();

            $table->string('commentaire', 100)->nullable();
            $table->char('valide', 50);
            $table->timestamps();

            $table->unsignedInteger('protocole_id');
            $table->integer('patient_id');
            $table->integer('medecin_id');
            $table->string('pathologies_id',5)->collation('latin1_swedish_ci');    

            $table->foreign('pathologies_id')->references('id')->on('pathologies')->onDelete('cascade');
            $table->foreign('protocole_id')->references('id')->on('protocole')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('medecin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traitements');
    }
}
