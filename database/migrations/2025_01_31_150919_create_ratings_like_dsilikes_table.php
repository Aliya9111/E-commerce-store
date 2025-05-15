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
        Schema::create('ratings_like_dsilikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_rating_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('likes')->default(0);
            $table->tinyInteger('dislikes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings_like_dsilikes');
    }
};
