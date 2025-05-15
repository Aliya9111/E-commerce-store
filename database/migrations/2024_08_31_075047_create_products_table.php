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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('ShortDescription')->nullable();
            $table->text('Description')->nullable();
            $table->text('Shipping_returns')->nullable();
            $table->text('relatedProducts')->nullable();
            $table->string('images')->nullable();
            $table->double('price',10,2);
            $table->double('compare_price',10,2)->nullable();
            $table->foreignId('categories_id')->constrained()->onDelete('cascade');
            $table->foreignId('Subcategories_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('brands_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->enum('track_qty',['on','off'])->default('on');
            $table->integer('quantity')->nullable();
            $table->enum('pstatus',['Yes','No'])->default('Yes');
            $table->enum('ProductFeature',['Yes','No'])->default('Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
