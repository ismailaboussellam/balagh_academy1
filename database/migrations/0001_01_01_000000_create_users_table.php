<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->unsignedTinyInteger('birth_day')->nullable();
            $table->unsignedTinyInteger('birth_month')->nullable();
            $table->unsignedSmallInteger('birth_year')->nullable();
            $table->string('nationality')->nullable();
            $table->string('residence_country')->nullable();
            $table->enum('user_type', ['admin', 'ostad', 'talib', 'ab'])->default('talib');
            $table->enum('domain', ['ta3lim_quran', 'dorous_diniya', 'ta3lim_lugha'])->nullable();
            $table->enum('fi2a', ['sighar', 'kibar'])->nullable();
            $table->string('code')->nullable()->unique();
            $table->foreignId('parent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
