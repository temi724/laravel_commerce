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
        Schema::table('admins', function (Blueprint $table) {
            // Change id to string type for MongoDB-like ObjectId
            $table->string('id', 24)->change();

            // Add the required fields
            $table->string('name')->after('id');
            $table->string('email')->unique()->after('name');
            $table->string('phone_number')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'phone_number']);
            $table->id()->change(); // Change back to auto-incrementing ID
        });
    }
};
