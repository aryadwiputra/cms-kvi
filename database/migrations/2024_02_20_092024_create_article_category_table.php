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
            $table->unsignedBigInteger('article_id'); // Menggunakan unsignedBigInteger() untuk tipe kolom
            $table->unsignedBigInteger('category_id'); // Menggunakan unsignedBigInteger() untuk tipe kolom
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
