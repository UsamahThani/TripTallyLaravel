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
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('cart_id');
            $table->uuid('trip_id');
            $table->string('place_id');
            $table->string('place_name');
            $table->string('place_location');
            $table->decimal('price', 10, 2);

            $table->primary(['cart_id', 'trip_id']);
            $table->foreign('trip_id')->references('trip_id')->on('trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
