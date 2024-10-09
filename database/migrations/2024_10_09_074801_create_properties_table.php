<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('propertyName');
            $table->integer('totalUnits');
            $table->string('city');
            $table->float('waterRate')->nullable();
            $table->string('electricityRate')->nullable();
            $table->string('penaltyPercentage')->nullable();
            $table->string('streetName')->nullable();
            $table->text('paymentUnstructions')->nullable();
            // $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
