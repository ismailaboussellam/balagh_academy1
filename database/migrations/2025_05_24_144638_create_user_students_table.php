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
        Schema::create('user_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('gender')->nullable();
            $table->integer('birth_day')->nullable();
            $table->integer('birth_month')->nullable();
            $table->integer('birth_year')->nullable();
            $table->string('nationality')->nullable();
            $table->string('residence_country')->nullable();
            $table->string('domain')->nullable();
            $table->enum('fi2a', ['sighar', 'kibar'])->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_students');
    }
};
