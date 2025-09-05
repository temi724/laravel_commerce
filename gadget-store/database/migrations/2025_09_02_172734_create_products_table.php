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
            $table->string('id', 24)->primary(); // MongoDB-like ObjectId length
            $table->string('product_name');
            $table->json('reviews')->nullable(); // Array of review strings
            $table->decimal('price', 10, 2);
            $table->text('overview')->nullable();
            $table->text('description')->nullable();
            $table->text('about')->nullable();
            $table->json('images_url')->nullable(); // Array of image URLs
            $table->json('what_is_included')->nullable(); // Array of included items
            $table->json('specification')->nullable(); // JSON object with nested structure
            $table->boolean('in_stock')->default(true);
            $table->enum('product_status', ['new', 'uk_used', 'refurbished'])->default('new');
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
