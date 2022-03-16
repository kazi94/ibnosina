<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathologiesProtocoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathologies_protocole', function (Blueprint $table) {

            $table->integer('protocole_id')->unsigned()->index();
            $table->foreign('protocole_id')->references('id')->on('protocole')->onDelete('cascade');


            $table->string('pathologies_id',5)->collation('latin1_swedish_ci')->index();         
            $table->foreign('pathologies_id')->references('id')->on('pathologies')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pathologies_protocole');
    }
}
