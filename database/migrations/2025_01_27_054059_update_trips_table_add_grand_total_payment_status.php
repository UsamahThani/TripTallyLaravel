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
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('grand_total', 10, 2)->after('user_id');  // Adds the 'grand_total' field as a decimal with 2 decimal points.
            $table->boolean('payment_status')->default(0)->after('grand_total');  // Adds 'payment_status' field with 0 for not paid and 1 for paid.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['grand_total', 'payment_status']);
        });
    }
};
