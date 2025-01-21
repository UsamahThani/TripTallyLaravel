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
        Schema::table('users', function (Blueprint $table) {
            // Drop the id 
            $table->dropPrimary();
            
            //Change id to UUID
            $table->uuid('id')->primary()->change();

            //Remove remember_token column
            $table->dropColumn('remember_token');

            // Add role column
            $table->enum('role', ['customer', 'admin'])->default('customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //Revert id field to big integer
            $table->bigIncrements('id')->unsigned()->change();

            //Add remember_token column
            $table->string('remember_token', 100)->nullable();

            // Drop role column
            $table->dropColumn('role');
        });
    }
};
