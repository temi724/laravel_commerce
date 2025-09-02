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
        Schema::create('sales', function (Blueprint $table) {
            $table->string('id', 24)->primary(); // MongoDB-like ObjectId length
            $table->string('username');
            $table->string('emailaddress');
            $table->string('phonenumber');
            $table->string('location');
            $table->string('state');
            $table->string('city');
            $table->json('product_ids'); // Array of product IDs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
