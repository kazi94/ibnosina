<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicamentSequencetypeTable extends Migration
{
    // *********** La table pivot(jonction) entre la table sequencetype et les tables  ************

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicament_sequencetype', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('sequencetype_id')->unsigned();
            //$table->integer('medicament_id')->nullable();
            //$table->integer('sub_id')->nullable();
            $table->integer('sp_id')->nullable();
            $table->integer('posologie');            
            //$table->timestamps();

            $table->foreign('sequencetype_id')->references('id')->on('sequencetype')->onDelete('cascade');
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicament_sequencetype');
    }
}
