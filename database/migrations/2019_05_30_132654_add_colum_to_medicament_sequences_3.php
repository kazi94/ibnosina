<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumToMedicamentSequences3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('medicament_sequence', function (Blueprint $table) {
            $table->string('u1', 20)->nullable();
            $table->string('u2', 20)->nullable();
            $table->string('u3', 20)->nullable();

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
            $table->dropColumn(['u1','u2','u3']);
        });
    }
}
