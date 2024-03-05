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
        Schema::create('travel_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('travel_package_id')->index()->nullable();
            $table->foreign('travel_package_id')->references('id')->on('travel_packages');
            $table->uuid('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('status');
            $table->integer('amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_transactions');
    }
};
