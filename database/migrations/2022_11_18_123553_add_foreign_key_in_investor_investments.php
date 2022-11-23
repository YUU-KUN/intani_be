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
        Schema::table('investor_investments', function (Blueprint $table) {
            $table->foreign('investor_id')->references('id')->on('investors')->onDelete('cascade');
            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investor_investments', function (Blueprint $table) {
            //x
        });
    }
};
