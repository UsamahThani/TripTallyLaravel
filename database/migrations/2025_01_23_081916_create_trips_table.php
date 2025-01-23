<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->uuid('trip_id')->primary();
            $table->string('from_location');
            $table->string('dest_location');
            $table->date('depart_date');
            $table->date('return_date');
            $table->decimal('budget', 8, 2);
            $table->integer('person_num');
            $table->char('user_id', 36);  // Ensure this is unsignedBigInteger
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
