<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumToPrescriptionChimioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prescriptions_chimio', function (Blueprint $table) {
            $table->text('commentaireMed')->nullable();
            $table->text('commentairePha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescriptions_chimio', function (Blueprint $table) {
            $table->dropColumn(['commentaireMed', 'commentairePha']);
        });
    }
}
