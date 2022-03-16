<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeingkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicament_sequencetype', function(Blueprint $table) {
            //$table->foreign('medicament_id')->references('SP_CODE_SQ_PK')->on('sp_specialite')->onDelete('cascade');;
            $table->foreign('sp_id')->references('COSAC_SP_CODE_FK_PK')->on('cosac_compo_subact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('medicament_sequencetype', function (Blueprint $table) {
             $table->dropForeign(['sp_id']);
        });
    }
}
