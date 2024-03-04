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
        Schema::create('article_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('article_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade'); // Menambahkan onDelete('cascade') untuk menghapus kategori yang terkait ketika artikel dihapus
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // Menambahkan onDelete('cascade') untuk menghapus artikel yang terkait ketika kategori dihapus
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_category');
    }
};
