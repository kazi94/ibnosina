<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocole', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 100);
            $table->integer('nbrcure_min');
            $table->integer('nbrcure_max');
            $table->integer('intervalle_cure');
            $table->integer('nbr_sequence');
            $table->text('remarque')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protocole');
    }
}
