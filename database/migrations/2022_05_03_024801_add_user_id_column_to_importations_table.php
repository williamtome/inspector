<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('importations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                ->after('id')
                ->index();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('importations', function (Blueprint $table) {
            $table->dropForeign('importations_user_id_index');
            $table->dropColumn('user_id');
        });
    }
};
