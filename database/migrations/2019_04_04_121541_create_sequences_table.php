<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jour');
            $table->float('poids');
            $table->integer('taille');
            $table->float('masse');
            $table->boolean('confirmed');
            $table->timestamps();
            
            $table->unsignedInteger('cure_id');
            $table->unsignedInteger('protocole_id');

            $table->foreign('cure_id')->references('id')->on('cure')->onDelete('cascade');
            $table->foreign('protocole_id')->references('id')->on('protocole')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequences');
    }
}
