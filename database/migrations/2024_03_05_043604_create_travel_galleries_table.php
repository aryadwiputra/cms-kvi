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
        Schema::create('travel_galleries', function (Blueprint $table) {
            $table->id();
            $table->uuid('travel_package_id')->index()->nullable();
            $table->foreign('travel_package_id')->references('id')->on('travel_packages');
            $table->string('image');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_galleries');
    }
};
