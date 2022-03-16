<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediParasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medi_paras', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('medicament_id')->index();
            $table->foreign('medicament_id')->references('SP_CODE_SQ_PK')->on('sp_specialite')->onDelete('cascade');

            $table->float('volume_medi')->nullable();
            $table->string('solvant_recon',100)->nullable();
            $table->string('solvant_dilu',100)->nullable();
            $table->string('remarque',100)->nullable();

            $table->text('e1',200)->nullable();
            $table->text('e2',200)->nullable();
            $table->text('e3',200)->nullable();
            $table->text('e4',200)->nullable();       

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
        Schema::dropIfExists('medi_paras');
    }
}
