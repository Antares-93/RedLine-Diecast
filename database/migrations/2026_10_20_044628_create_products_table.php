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
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('sku')->unique(); // Kode seri blister / SKU diecast
            $table->string('name'); // Nama mobil diecast (e.g., Nissan Skyline GT-R R34)
            $table->string('brand')->nullable(); // Hot Wheels, Mini GT, Tomica, Matchbox
            $table->string('scale')->default('1:64'); // Skala diecast
            $table->decimal('purchase_price', 15, 2); // Harga modal kulakan
            $table->decimal('selling_price', 15, 2); // Harga jual toko
            $table->integer('stock')->default(0); // Stok aktual
            $table->integer('minimum_stock')->default(3); // Batas alert stok menipis
            $table->string('image')->nullable(); // Foto blister/diecast
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
