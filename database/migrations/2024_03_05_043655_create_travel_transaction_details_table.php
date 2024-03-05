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
        Schema::create('travel_transaction_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('transaction_id')->index()->nullable();
            $table->foreign('transaction_id')->references('id')->on('travel_transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('total_person');
            $table->string('country');
            $table->string('is_visa')->default(false);
            $table->string('visa')->nullable();
            $table->string('passport');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_transaction_details');
    }
};
