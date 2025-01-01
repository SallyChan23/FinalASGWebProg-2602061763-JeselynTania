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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Match with 'name'
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender', ['Male', 'Female']);
            $table->json('field_of_work'); // Match with 'field_of_work'
            $table->string('linkedin_username');
            $table->string('mobile_number');
            $table->integer('registration_fee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
