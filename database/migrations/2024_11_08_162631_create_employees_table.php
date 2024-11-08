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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');             // Employee First Name (required)
            $table->string('last_name');              // Employee Last Name (required)
            $table->foreignId('company_id')           // Foreign key to companies table
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('email')->nullable();      // Employee Email
            $table->string('phone')->nullable();      // Employee Phone
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
