<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToCureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cure', function (Blueprint $table) {
            
            $table->unsignedInteger('traitement_id');
            $table->foreign('traitement_id')->references('id')->on('traitements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cure', function (Blueprint $table) {
            $table->dropForeign(['traitement_id']);
        });
    }
}
