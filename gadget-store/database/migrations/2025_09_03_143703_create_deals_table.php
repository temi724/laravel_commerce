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
        Schema::create('deals', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->string('product_name');
            $table->string('category_id', 24)->nullable();
            $table->json('reviews')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->text('overview')->nullable();
            $table->text('description')->nullable();
            $table->text('about')->nullable();
            $table->json('images_url')->nullable();
            $table->json('colors')->nullable();
            $table->json('what_is_included')->nullable();
            $table->json('specification')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->timestamps();

            $table->index('category_id');
            $table->index('in_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
