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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('image');
            $table->longText('content');
            $table->enum('status', ['PUBLISH', 'DRAFT']);
            $table->uuid('create_by')->index()->nullable();
            $table->uuid('update_by')->index()->nullable();
            $table->uuid('delete_by')->index()->nullable();
            $table->timestamps();

            // Relations
            $table->foreign('create_by')->references('id')->on('users');
            $table->foreign('update_by')->references('id')->on('users');
            $table->foreign('delete_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};