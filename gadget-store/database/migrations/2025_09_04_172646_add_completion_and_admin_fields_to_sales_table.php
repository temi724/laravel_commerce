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
        Schema::table('sales', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('payment_status');
            $table->string('approved_by_admin')->nullable()->after('completed_at');
            $table->timestamp('payment_approved_at')->nullable()->after('approved_by_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['completed_at', 'approved_by_admin', 'payment_approved_at']);
        });
    }
};
