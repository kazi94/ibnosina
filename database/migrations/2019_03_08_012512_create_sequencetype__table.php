<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequencetypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequencetype', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('protocole_id');
            $table->integer('jour');
            $table->timestamps();
            
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
        Schema::dropIfExists('sequencetype');
    }
}
