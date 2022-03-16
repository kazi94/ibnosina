<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumToTableTraitement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('traitements', function (Blueprint $table) {
            $table->text('comm_arrete', 100)->nullable();
            $table->date('date_arrete')->nullable();
            $table->integer('id_user_arrete')->nullable();
            $table->foreign('id_user_arrete')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('traitements', function (Blueprint $table) {
            $table->dropForeign(['id_user_arrete']);
            $table->dropColumn(['comm_arrete','date_arrete']);

        });
    }
}
