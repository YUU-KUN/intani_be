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
        Schema::create('investments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('commodity');
            $table->integer('duration');
            $table->string('address');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->uuid('farmer_id')->nullable();
            $table->uuid('farm_group_id')->nullable();
            $table->timestamps();
            
            $table->foreign('farmer_id')->references('id')->on('farmers')->onDelete('cascade');
            $table->foreign('farm_group_id')->references('id')->on('farm_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investments');
    }
};
