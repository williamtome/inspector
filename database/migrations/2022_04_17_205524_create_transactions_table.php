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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('origin_bank')->nullable();
            $table->string('origin_agency')->nullable();
            $table->string('origin_account')->nullable();
            $table->string('destiny_bank')->nullable();
            $table->string('destiny_agency')->nullable();
            $table->string('destiny_account')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->dateTime('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
