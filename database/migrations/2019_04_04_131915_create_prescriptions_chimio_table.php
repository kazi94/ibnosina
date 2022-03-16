<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsChimioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions_chimio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sequence_id');
            $table->date('med_validate_at')->nullable();
            $table->date('phar_validate_at')->nullable();
            $table->integer('medecin_id')->nullable();
            $table->integer('pharmacien_id')->nullable();

            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('cascade');
            $table->foreign('medecin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pharmacien_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions_chimio');
    }
}
