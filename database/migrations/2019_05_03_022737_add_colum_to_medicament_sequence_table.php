<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumToMedicamentSequenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicament_sequence', function (Blueprint $table) {
            $table->string('etat', 20)->nullable();
            $table->float('reduction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medicament_sequence', function (Blueprint $table) {
            $table->dropColumn(['etat', 'reduction']);
        });
    }
}
