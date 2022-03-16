<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicamentSequenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicament_sequence', function (Blueprint $table) {
            $table->date('date_debut')->nullable();
            $table->time('heure')->nullable();
            $table->text('remarque')->nullable();
            $table->float('posologie');
            $table->string('voie', 50);
            $table->string('type', 50);
            $table->float('dose_calcule')->nullable();
            
            $table->integer('sequence_id')->unsigned()->index();
            $table->integer('medicament_id')->index();

            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('cascade');
            $table->foreign('medicament_id')->references('SP_CODE_SQ_PK')->on('sp_specialite')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicament_sequence');
    }
}
