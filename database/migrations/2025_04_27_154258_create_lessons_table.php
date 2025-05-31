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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('video_url')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->string('image_path')->nullable();
            $table->timestamps();
            //

            // Add the foreign key constraint separately with onDelete cascade
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
